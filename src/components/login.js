import React from 'react';
import { Formik, Form } from "formik";
import '../stylesheet/styles.css';
import hat from "../img/hat.png";
import mainLogo from "../img/school-logo.png";
import { MyTextInput, loginSchema } from "./action";
import axios from 'axios';



const Login = () => {
    return (
        <div className="container-fluid p-5">
        <div className="row pb-3">
            <div className="col">
                <div className="row"> 
                    <div className="col d-flex justify-content-center">
                        <img src={mainLogo} className="head-logo" alt="Hogwarts Logo" height="200" />
                        <h1 className="login-header pt-5 ps-4">Hogwarts School of Witchcraft and Wizardry</h1>
                    </div>                
                </div>
            </div>
        </div>
        <div className="row pt-5">
            <div className="col-sm-6 ms-5 text-center">
                <h2 className="login-quote">"We are only as strong as we are united, weak as <br/> we are divided." -Albus Dumbledore</h2>
                <img src={hat} alt="Sorting Hat" height="250" />
            </div>
            <div className="col-sm-4 ms-5 bg-light form-container">
                <center>
                <h1 className="form-header pb-3">Login</h1>
                    <Formik
                        initialValues={{ email: '', password: '' }}
                        validationSchema={ loginSchema }
                        onSubmit={(values) => {
                            let formData = new FormData();
                            formData.append('email', values.email)
                            formData.append('password', values.password)
                            axios({
                                method: 'POST',
                                url: 'http://localhost/Hogwarts-Academic-Module/src/php/login-action.php',
                                data: formData,
                                config: { headers: {'Content-Type': 'multipart/form-data' }},
                                withCredentials: true
                            }) 
                            .then(function(res) {
                                if(res.data.type === "student") {
                                    window.location.replace("student")
                                }
                                else if(res.data.type === "professor") {
                                    window.location.replace("professor")
                                }
                                else if(res.data.type === "admin") {
                                    window.location.replace("admin")
                                } else {
                                    alert(res.data.message);
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }}
                    >
                        <Form>
                            <div className="input-group mb-3">
                                <span className="input-group-text">
                                    <i className="fas fa-user"></i>
                                </span>
                                <MyTextInput
                                    name="email"
                                    type="email"
                                    placeholder="Email"
                                    className="form-control"
                                />
                            </div>
                            <div className="input-group mb-4">
                                <span className="input-group-text">
                                    <i className="fas fa-key"></i>
                                </span>
                                <MyTextInput
                                    // label="Password"
                                    name="password"
                                    type="password"
                                    placeholder="Password"
                                    className="form-control"
                                />
                            </div>
                            <button type="submit" className="btn btn-primary mb-4">Login</button>
                        </Form>
                    </Formik>
                </center>
            </div>
        </div>
    </div>
    );
};

export default Login;
