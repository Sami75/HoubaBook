import { Component, OnInit } from '@angular/core';
import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';
import { Response } from "@angular/http";
import { User } from '../users/user';
import { UserService } from '../users/user.service';
import { Subject } from 'rxjs/Subject';
import {debounceTime, distinctUntilChanged, map} from 'rxjs/operators';

const friends = [];

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  users: User[];
  datas: User[];
  closeResult: string;
  public model: any;

  constructor(private userService: UserService, private modalService: NgbModal) { }

  ngOnInit() {
  	this.userService.getFriends()
    .subscribe(
      (users: User[]) => this.users = users,
      (error: Response) => console.log(error)
      );
  }

  search($event) {
    let q = $event.target.value;

    this.userService.getAll(q)
    .subscribe(
      (users: User[]) => this.datas = users,
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
  
  add(data) {
    this.userService.send(data.id)
    .subscribe(
      () => {    
        console.log("Demande d'invitation envoyé");
        location.reload();
      }
      );
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

  annuler(data) {
    this.userService.annuler(data.id)
    .subscribe(
      () => {    
        console.log("Vous avez annulé votre demande d'amis pour " + data.prenom + " " + data.nom);
        location.reload();
      }
      );
  }

  delete(data) {
    this.userService.delete(data.id)
    .subscribe(
      () => {    
        console.log("Ami supprimé de la liste d'ami.");
        location.reload();
      }
      );
  }


}
