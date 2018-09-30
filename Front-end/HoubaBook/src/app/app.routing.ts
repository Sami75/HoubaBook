import { ModuleWithProviders } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";

import { SignupComponent } from "./signup/signup.component";
import { SigninComponent } from "./signin/signin.component";
import { HomeComponent } from "./home/home.component";
import { AuthGuard } from "./auth/auth.guard";

const APP_ROUTES : Routes = [
	{ path: 'signup', component: SignupComponent },
	{ path: 'signin', component: SigninComponent },
	{ path: 'home', component: HomeComponent, canActivate: [AuthGuard] }

];

export const routing: ModuleWithProviders = RouterModule.forRoot(APP_ROUTES);