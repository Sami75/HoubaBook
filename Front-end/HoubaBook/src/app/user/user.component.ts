import { Component, OnInit, Input } from '@angular/core';
import { User } from '../users/user';
import { UserService } from '../users/user.service';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {
  @Input() user: User;

  constructor(private userService: UserService) { }

  ngOnInit() {
  }

  delete(user) {
  	    this.userService.delete(user.id)
      .subscribe(
        () => { 	 
        	console.log("Ami supprimé de la liste d'ami.");
        	location.reload();
        }
      );
  }

}
