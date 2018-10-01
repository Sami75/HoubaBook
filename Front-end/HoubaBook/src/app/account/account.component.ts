import { Component, OnInit } from '@angular/core';
import { Response } from "@angular/http";
import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';
import { User } from '../users/user';
import { UserService } from '../users/user.service';
import { AuthService } from '../auth/auth.service';
import { SigninComponent } from "../signin/signin.component";


@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {
  user: User;
  userNom = '';
  userPrenom = '';
  userEmail = '';
  userdateNaissance ='';
  userTel = '';
  userRace = '';
  userAdresse = '';
  userSexe = '';
  userPrivee = '';
  closeResult: string;
  

  constructor(private userService: UserService, private authService: AuthService, private modalService: NgbModal) { }

  ngOnInit() {
  		const token = this.authService.getToken();
  		const base64Url = token.split('.')[1];
	    const base64 = base64Url.replace('-', '+').replace('_', '/');
  		const user = JSON.parse(window.atob(base64));
    this.userService.getById(user.sub)
  		.subscribe(
  			(user: User) => this.user = user,
  			(error: Response) => console.log(error)
  		);
  }


  open(content) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;
    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
    this.userNom = this.user.nom;
    this.userPrenom = this.user.prenom;
    this.userEmail = this.user.email;
    this.userdateNaissance = this.user.dateNaissance;
    this.userTel = this.user.tel;
    this.userRace = this.user.race;
    this.userAdresse = this.user.adresse;
    this.userSexe = this.user.sexe;
    this.userPrivee = this.user.privee;
    console.log(this.userPrivee);
  }

  private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return  `with: ${reason}`;
    }
  }

  onEdit(form: ngForm) {
    this.userService.update(this.user.id, form.value.nom, form.value.prenom, form.value.email, form.value.dateNaissance, form.value.tel, form.value.sexe, form.value.adresse, form.value.race, form.value.privee)
      .subscribe(
        response => console.log(response),
        error => console.log(error)
      );

  }

}
