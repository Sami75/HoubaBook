import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';

import { Observable, Subject } from 'rxjs';  
import { UserService } from './users/user.service'; 
import { AuthService } from "./auth/auth.service";
import { User } from './users/user'

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'HoubaBook';
  datas: User[] = [];
  
  constructor(private authService: AuthService, private userService: UserService, private router: Router) {
  }

  ngOnInit() {
  	if(this.authService.getToken()) {
  		this.router.navigate(['home']).then(() => {
        this.userService.invitations()
        .subscribe(
          (users: User[]) => this.datas = users,
          (error: Response) => console.log(error) 
          )});
  	} else {
  		this.router.navigate(['/']);
  	}
  	console.log(this.authService.getToken());
  }

  accept(data) {
    this.userService.accept(data.id)
    .subscribe(
      () => {    
        console.log(data.prenom + " " + data.nom + " a été ajouté a votre liste d'amis.");
        location.reload();
      }
      );
  }

  refuse(data) {
    this.userService.refuse(data.id)
    .subscribe(
      () => {    
        console.log("Vous avez décliné la demande d'amis de " + data.prenom + " " + data.nom);
        location.reload();
      }
      );
  }

}
