import React, { Component } from 'react';
import { useField } from "formik";
import 'bootstrap/dist/css/bootstrap.min.css';
import * as yup from "yup";
import { Nav } from 'react-bootstrap';
import axios from 'axios';
import styled from "@emotion/styled";
import "../stylesheet/styles.css"
import { Button } from 'react-bootstrap';

export const loginSchema = yup.object().shape({
  email: yup.string().email('Invalid email address').required('Required'),
  password: yup.string().required('Required')
});

export const addStudentSchema = yup.object().shape({
  fname: yup.string().min(3).required('Required'),
  mname: yup.string().min(3).required('Required'),
  lname: yup.string().min(3).required('Required'),
  email: yup.string().email('Invalid email address').required('Required'),
  password: yup.string().min(5).required('Required'),
  year: yup.number().required('Required'),
  house: yup.number().required('Required')
});

export const addProfSchema = yup.object().shape({
  fname: yup.string().min(3).required('Required'),
  mname: yup.string().min(3).required('Required'),
  lname: yup.string().min(3).required('Required'),
  email: yup.string().email('Invalid email address').required('Required'),
  password: yup.string().min(5).required('Required'),
  subject: yup.string().required('Required')
});

export const editStudentSchema = yup.object().shape({
  userID: yup.number(),
  fname: yup.string().min(3).required('Required'),
  mname: yup.string().min(3).required('Required'),
  lname: yup.string().min(3).required('Required'),
  email: yup.string().email('Invalid email address').required('Required'),
  password: yup.string().min(5),
  year_level: yup.number().required('Required')
});

export const editProfSchema = yup.object().shape({
  userID: yup.number(),
  fname: yup.string().min(3).required('Required'),
  mname: yup.string().min(3).required('Required'),
  lname: yup.string().min(3).required('Required'),
  email: yup.string().email('Invalid email address').required('Required'),
  password: yup.string().min(5),
  subjectID: yup.number().required('Required')
});

export const addCourseSchema = yup.object().shape({
  subject_name: yup.string().min(3).required('Required'),
  description: yup.string().required('Required')
});

export const editCourseSchema = yup.object().shape({
  subjectID: yup.number(),
  subject_name: yup.string().min(3).required('Required'),
  description: yup.string().min(5).required('Required')
});

export const editGradesSchema = yup.object().shape({
  userID: yup.number(),
  midtermGrade: yup.number().min(1, 'Must be 1-5').max(5, 'Must be 1-5'),
  finalGrade: yup.number().min(1, 'Must be 1-5').max(5, 'Must be 1-5')
});

const StyledErrorMessage = styled.div`
  font-size: 12px;
  color: var(--red-600);
  width: 210px;

  &:before {
    content: "❌ ";
    font-size: 10px;
  }
`;

export const MyTextInput = ({ label, ...props }) => {
  const [field, meta] = useField(props);
  return (
    <>
      <label htmlFor={props.id || props.name}>{label}</label>
      <input className="text-input" {...field} {...props} />
      {meta.touched && meta.error ? (
        <StyledErrorMessage>{meta.error}</StyledErrorMessage>
      ) : null}
    </>
  );
};

export const MyTextArea = ({ label, ...props }) => {
  const [field, meta] = useField(props);
  return (
    <>
      <label htmlFor={props.id || props.name}>{label}</label>
      <textarea className="text-input" {...field} {...props} />
      {meta.touched && meta.error ? (
        <StyledErrorMessage>{meta.error}</StyledErrorMessage>
      ) : null}
    </>
  );
};

export const MySelect = ({ label, ...props }) => {
  const [field, meta] = useField(props);
  return (
    <div>
      <label htmlFor={props.id || props.name}>{label}</label>
      <select {...field} {...props} />
      {meta.touched && meta.error ? (
        <StyledErrorMessage>{meta.error}</StyledErrorMessage>
      ) : null}
    </div>
  );
};
export class LogOut extends Component {
    constructor(props) {
      super(props);
      this.logoutClick = this.logoutClick.bind(this);
    }

    logoutClick() {
      axios.get('http://localhost/Hogwarts-Academic-Module/src/php/logout-action.php', {
        withCredentials: true
      })
      .then(function() {
        window.location.replace('/');
      });
    }

    render() {
      return(
        <Nav.Link onClick={this.logoutClick}>Logout</Nav.Link>
      );
    }
}

export class FetchSubjects extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-subjects-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result) => {
        return (
          <option name="SID" key={result.subjectID} value={result.subjectID}>{result.subject_name}</option>
         );
      })
    );
  }

}

export class FetchStudents extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-students-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result) => {
        return (
          <tr key={result.userID}>
            <td>{result.userID}</td>
            <td>{result.fullname}</td>
            <td>{result.year_level}</td>
            <td>{result.house}</td>
            <td>{result.email}</td>
            <td>
              <Button href={`/admin/student/${result.userID}`} variant="success" type="submit">View Info</Button>          
            </td>
          </tr>
        );
      })
    );
  }
}

export class FetchProfs extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-profs-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result) => {
        return (
          <tr key={result.userID}>
            <td>{result.userID}</td>
            <td>{result.fullname}</td>
            <td>{result.email}</td>
            <td>{result.subject_name}</td>
            <td>
            <Button href={`/admin/instructor/${result.userID}`} variant="success" type="submit">View Info</Button>
            </td>
          </tr>
        );
      })
    );
  }
}

export class FetchSubjects2 extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-subjects-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result) => {
        return (
          <tr key={result.subjectID}>
            <td>{result.subjectID}</td>
            <td>{result.subject_name}</td>
            <td>{result.description}</td>
            <td>
            <Button href={`/admin/course/${result.subjectID}`} variant="success" type="submit">View Info</Button>           
            </td>
          </tr>
         );
      })
    );
  }
}

export class FetchStudentsGrades extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-students-grades-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result) => {
        return (
          <tr key={result.userID}>
            <td>{result.userID}</td>
            <td>{result.fullname}</td>
            <td>{result.midtermGrade}</td>
            <td>{result.finalGrade}</td>
            <td>
              <Button href={`/professor/grading/${result.userID}`} variant="success" type="submit">Edit Grades</Button>           
            </td>
          </tr>
         );
      })
    );
  }
}

export class FetchStudentSubjects extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-subjects-enroll-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result, i) => {
        return (
          <tr key={i}>
            <td>{result.subjectID}</td>
            <td>{result.subject_name}</td>
            <td>{result.description}</td>
            <td>{result.fullname}</td>
            <td>
            <a type="submit" className="btn btn-primary" variant="success" href={`http://localhost/Hogwarts-Academic-Module/src/php/enroll-course-action.php?id=${result.subjectID}`}>Enroll</a>           
            </td>
          </tr>
         );
      })
    );
  }
}

export class FetchStudentSubjectsTaken extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-subjects-enrolled-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result, i) => {
        return (
          <tr key={i}>
            <td>{result.subjectID}</td>
            <td>{result.subject_name}</td>
            <td>{result.description}</td>
            <td>{result.fullname}</td>
            <td>
            <a type="submit" className="btn btn-danger" variant="success" href={`http://localhost/Hogwarts-Academic-Module/src/php/drop-course-action.php?id=${result.enrolledID}`}>Drop</a>           
            </td>
          </tr>
         );
      })
    );
  }
}

export class FetchSubjectsStudentGrades extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    var self = this;
    axios({
      method: 'GET',
      url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-subjects-student-grades-action.php',
      withCredentials: true
    })
    .then(function(res) {
      self.setState({data: res.data});
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  render() {
    return (
      this.state.data.map((result, i) => {
        return (
          <tr key={i}>
            <td>{i+1}</td>
            <td>{result.subject_name}</td>
            <td>{result.midtermGrade}</td>
            <td>{result.finalGrade}</td>
            <td>{result.remark}</td>
          </tr>
         );
      })
    );
  }
}

// class SandBox extends Component {
//     constructor(props) {
//         super(props);
//         this.state = {
//             data: []
//         };
//     }

//     componentDidMount() {
//         var self = this;
//         axios({
//           method: 'GET',
//           url: 'http://localhost/Hogwarts-Academic-Module/src/php/fetch-user-action.php',
//           withCredentials: true
//         })
//         .then(function(res) {
//           self.setState({data: res.data});   
//         })
//         .catch(function (error) {
//           console.log(error);
//        });
       
//     }
    
//     render() {
//       var fetch = this.state.data;
//         return (
//               this.state.data.map((result) => {
//                 return (
//                      <ul key={result.userID}>
//                       <li>{result.userID}</li>  
//                       <li>{result.fname}</li>    
//                       <li>{result.lname}</li>  
//                     </ul>
//                  );
//               })
//               <h1>{ fetch.fname }</h1>
//         );
//     }
// }
