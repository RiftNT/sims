import React, { Component } from 'react';
import '../stylesheet/homepage.css';
import mainLogo from "../img/school-logo.png";
export default class Footer extends Component {
    render() {
        return(
            <div className="footer">
                <div className="footer-1">
                  <center>
                <img
                  src={mainLogo}
                  width="25%"
                  height="auto"
                  alt="Hogwarts Logo"
                />
                </center>
                </div>
                <div className="footer-2">
                  <h5>© 2021 Hogwarts School of Witchcraft and Wizardry</h5>
                </div>
                <div className="footer-3">
                  <h6>Contact Us:</h6>
                  <h6>Hogwarts Castle, Scotland, Great Britain</h6>
                  <h6>Phone: (605) 475-6961 </h6>
                </div>
            </div>
        );
    }
}