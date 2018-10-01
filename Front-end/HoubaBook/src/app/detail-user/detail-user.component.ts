import { Component, OnInit } from '@angular/core';
import { Response } from "@angular/http";
import { Router, ActivatedRoute } from '@angular/router';

import { Subject } from 'rxjs/Subjec';
import 'rxjs/add/operator/switchMap';
import { UserService } from '../users/user.service';
import { AuthService } from '../auth/auth.service';
import { User } from '../users/user';

@Component({
  selector: 'app-detail-user',
  templateUrl: './detail-user.component.html',
  styleUrls: ['./detail-user.component.css']
})
export class DetailUserComponent implements OnInit {
  user: User;
  const ismyfriend;

  constructor(private userService: UserService, private authService: AuthService, private route: ActivatedRoute,
  private router: Router) { }

  ngOnInit() {
        this.route.params
      .switchMap((params: Params) => this.userService.isMyFriend(+params['id']))
        .subscribe(
          ismyfriend => this.ismyfriend = ismyfriend,
          error => console.log(error)
        );

  	this.route.params
    	.switchMap((params: Params) => this.userService.getById(+params['id']))
    		.subscribe(
    			(user: User) => this.user = user,
		  		(error: Response) => console.log(error)
			);
  }

}
