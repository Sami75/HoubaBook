import { Injectable } from "@angular/core";
import { Http, Headers, Response } from "@angular/http";
import { Observable } from 'rxjs';
import { tap, map } from 'rxjs/operators';
import {Router} from '@angular/router';

@Injectable()
export class AuthService {
	
	constructor(private http: Http, private router: Router) {

	}

	signup(nom: string, prenom: string, email: string, password: string) {
		return this.http.post('http://localhost:8000/api/user/signup', 
			{nom: nom, prenom: prenom, email: email, password: password},
			{headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})}
		);
	}

	signin(email: string, password: string) {
	    return this.http.post('http://localhost:8000/api/user/signin',
	      {email: email, password: password},
	      {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})})
	      .pipe(map(
	        (response: Response) => {
	          const token = response.json().token;
	          const base64Url = token.split('.')[1];
	          const base64 = base64Url.replace('-', '+').replace('_', '/');
	          return {token: token, decoded: JSON.parse(window.atob(base64))};
	        }
	      ))
	      .pipe(tap(
        	tokenData => {
          		localStorage.setItem('token', tokenData.token);
          		this.router.navigate(['home']);
        	}
      	  )
      	);
    }

    connected() {
    	if(this.getToken()) {
    		return true;
    	}
    	else
    		return false;
    }

    getToken() {
    	return localStorage.getItem('token');
    }

     logout() {

        localStorage.removeItem('token');
    }
}