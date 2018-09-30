import { Injectable } from '@angular/core';
import { Http, Headers, Response } from "@angular/http";

import { User } from '../users/user';
import { AuthService } from "../auth/auth.service";

@Injectable()
export class UserService {
    constructor(private http: Http, private authService: AuthService) { }

    getAll() {
        const token = this.authService.getToken();
        return this.http.get<User[]>('http://localhost:8000/api/users?token=' + token);
    }

    getById(id: number) {
        return this.http.get('http://localhost:8000/api/user' + id);
    }

    newUserAmi(nom: string, prenom: string, email: string) {
        return this.http.post('http://localhost:8000/api/newUserAmi', 
            {nom: nom, prenom: prenom, email: email},
            {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})}
        );
    }

    update(id: number) {
        return this.http.put('http://localhost:8000/api/edit' + user.id);
    }

    send(id: number) {
        return this.http.post('http://localhost:8000/api/send' + id);
    }

    accept(id: number) {
        return this.http.put('http://localhost:8000/api/accept' + id);
    }

    delete(id: number) {
        return this.http.delete('http://localhost:8000/api/delete' + id);
    }

    refuse(id: number) {
        return this.http.delete('http://localhost:8000/api/refuse' + id);
    }

    annuler(id: number) {
        return this.http.delete('http://localhost:8000/api/annuler' + id);
    }

    search(search: string) {
        return this.http.post('http://localhost:8000/api/search' + search);
    }
}
