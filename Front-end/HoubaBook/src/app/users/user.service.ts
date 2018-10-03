import { Injectable } from '@angular/core';
import { Http, Headers, Response } from "@angular/http";
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs';
import { AuthService } from "../auth/auth.service";

@Injectable()
export class UserService {

    constructor(private http: Http, private authService: AuthService) { }

    getAll(q): Observable<any> {
        const token = this.authService.getToken();
        return this.http.get('http://localhost:8000/api/users/' + q + '?token=' + token)
        .map(
            (response: Response) => {
                let body = <User[]>response.json().users;
                return body || [];
            }
            );
    }

    getFriends(): Observable<any> {
        const token = this.authService.getToken();
        return this.http.get('http://localhost:8000/api/friends?token=' + token)
        .map(
            (response: Response) => {
                let body = <User[]>response.json().users;
                return body || [];
            }
            );
    }

    isMyFriend(id: number): Observable<any> {
        const token = this.authService.getToken();
        return this.http.get('http://localhost:8000/api/isMyFriend/' + id + '?token=' + token)
        .map(
            (response: Response) => {
                return response.json().ismyfriend;
                console.log(response.json().ismyfriend);
            }
            );
    }    

    getById(id: number): Observable<any> {
        const token = this.authService.getToken();
        return this.http.get('http://localhost:8000/api/user/' + id + '?token=' + token)
        .map(
            (response: Response) => {
                return response.json().user;
            }
            );
    }

    newUserAmi(nom: string, prenom: string, email: string) {
        const token = this.authService.getToken();        
        return this.http.post('http://localhost:8000/api/newUserAmi?token=' + token, 
            {nom: nom, prenom: prenom, email: email},
            {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})}
            );
    }

    update(id: number, nom: string, prenom: string, email: string, dateNaissance: date, tel: number, sexe: string, adresse: string, race: string, privee: number) {
        const token = this.authService.getToken();
        const body = JSON.stringify({nom: nom, prenom: prenom, email: email, dateNaissance: dateNaissance, tel: tel, sexe: sexe, adresse: adresse, race: race, privee: privee});
        return this.http.put('http://localhost:8000/api/edit/' + id + '?token=' + token, body, {headers: new Headers({'Content-Type' : 'application/json'})})
        .map(
            (response: Response) => response.json()
            );
    }

    send(id: number) {
        const token = this.authService.getToken();
        return this.http.post('http://localhost:8000/api/send/' + id + '?token=' + token,
            {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})}
            );
    }

    accept(id: number) {
        const token = this.authService.getToken();
        const headers = new Headers({'X-Requested-With': 'XMLHttpRequest'});
        return this.http.put('http://localhost:8000/api/accept/' + id + '?token=' + token, {headers: headers});
    }

    delete(id: number) {
        const token = this.authService.getToken();
        return this.http.delete('http://localhost:8000/api/delete/' + id + '?token=' + token);
    }

    refuse(id: number) {
        const token = this.authService.getToken();
        return this.http.delete('http://localhost:8000/api/refuse/' + id + '?token=' + token);
    }

    annuler(id: number) {
        const token = this.authService.getToken();
        return this.http.delete('http://localhost:8000/api/annuler/' + id + '?token=' + token);
    }

   invitations(): Observable<any> {
        const token = this.authService.getToken();
        return this.http.get('http://localhost:8000/api/invitations?token=' + token)
        .map(
            (response: Response) => {
                return response.json().users;
            }
            );
    }

}
