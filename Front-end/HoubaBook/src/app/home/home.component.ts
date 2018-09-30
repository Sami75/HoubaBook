import { Component, OnInit } from '@angular/core';

import { UserService } from '../users/user.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  private users: any;

  constructor(private userService: UserService) { }

  ngOnInit() {
  	this.userService.getAll().subscribe(data => {
  	  this.users = data;
  	});
  }

}
