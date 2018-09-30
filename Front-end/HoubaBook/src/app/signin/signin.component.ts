import { Component, OnInit } from '@angular/core';
import { NgForm } from "@angular/forms";
import {Router} from '@angular/router';

import { AuthService } from "../auth/auth.service";

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {

  constructor(private authService:  AuthService, private router: Router) { }

  ngOnInit() {
    this.authService.logout();
  }

  onSignIn(form: NgForm) {
  	this.authService.signin(form.value.email, form.value.password)
  		.subscribe(
  			decodedToken => console.log(decodedToken),
  			error => console.log(error)
  		);
  }

}
