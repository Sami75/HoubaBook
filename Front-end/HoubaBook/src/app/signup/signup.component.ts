import { Component, OnInit } from '@angular/core';
import { NgForm } from "@angular/forms";

import { AuthService } from "../auth/auth.service";

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

  constructor(private authService: AuthService) { }

  ngOnInit() {
  }

  onSignUp(form: NgForm) {
  	this.authService.signup(form.value.nom, form.value.prenom, form.value.email, form.value.password)
  		.subscribe(
  			response => console.log(response),
  			error => console.log(error)
  		);
  }
}
