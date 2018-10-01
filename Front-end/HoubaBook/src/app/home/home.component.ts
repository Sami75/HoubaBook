import { Component, OnInit } from '@angular/core';
import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';
import { Response } from "@angular/http";
import { User } from '../users/user';
import { UserService } from '../users/user.service';
import { Subject } from 'rxjs/Subjec';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  users: User[];
  closeResult: string;


  constructor(private userService: UserService, private modalService: NgbModal) { }

  ngOnInit() {
  	this.userService.getFriends()
  		.subscribe(
  			(users: User[]) => this.users = users,
  			(error: Response) => console.log(error)
  		);
  }

open(content) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;
    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
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

  invit(form: ngForm) {
    this.userService.newUserAmi(form.value.nom, form.value.prenom, form.value.email)
      .subscribe(
        response => console.log(response),
        error => console.log(error)
      );
  }
}
