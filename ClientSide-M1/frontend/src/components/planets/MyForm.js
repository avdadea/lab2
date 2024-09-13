import React, { Component } from "react";

class MyForm extends Component {
  state = {
    form: { name: "", type: "", isDeleted: "", isEdit: false },
    btnName: "Save",
    btnClass: "ui primary button submit-button"
  };

  isEmptyObj(obj) {
    return Object.entries(obj).length === 0 && obj.constructor === Object;
  }

  componentDidUpdate(prevProps) {
    if (prevProps !== this.props && !this.isEmptyObj(this.props.planet)) {
      this.setState({
        form: { ...this.props.planet, isEdit: true },
        btnName: "Update",
        btnClass: "ui orange button submit-button"
      });
      // console.log("update");
    }
  }

  onFormSubmit = event => {
    // prevent form submit
    event.preventDefault();

    // form validation
    if (this.formValidation()) {
      // send form data to app
      this.props.onFormSubmit(this.state.form);

      // change the button to save
      this.setState({
        btnName: "Save",
        btnClass: "ui primary button submit-button"
      });

      // clear form fields
      this.clearFormFields();
    }
  };

  handleChange = event => {
    const { name, value } = event.target;
    let form = this.state.form;
    form[name] = value;
    this.setState({ form });
  };

  formValidation = () => {
    // first name
    if (document.getElementsByName("name")[0].value === "") {
      alert("Enter  name");
      return false;
    }

    // last name
    if (document.getElementsByName("type")[0].value === "") {
      alert("Enter type");
      return false;
    }

    // email
    if (document.getElementsByName("isDeleted").value === "") {
      alert("Enter isDeleted");
      return false;
    }

    return true;
  };

  clearFormFields = () => {
    // console.log("clear");
    // change form state
    this.setState({
      form: { name: "", tpye: "", isDeleted: "", isEdit: false }
    });

    // clear form fields
    document.querySelector(".form").reset();
  };

  render() {
    return (
      <form className="ui form">
        <div className="fields">
          <div className="four wide field">
            <label>Name</label>
            <input
              type="text"
              name="name"
              placeholder="Name"
              onChange={this.handleChange}
              value={this.state.form.name}
            />
          </div>

          <div className="four wide field">
            <label>Type</label>
            <input
              type="text"
              name="type"
              placeholder="Type"
              onChange={this.handleChange}
              value={this.state.form.type}
            />
          </div>

          {/* <div className="six wide field">
            <label>isDeleted</label>
            <input
              type="boolean"
              name="isDeleted"
              placeholder=""
              onChange={this.handleChange}
              value={this.state.form.isDeleted}
            />
          </div> */}

          <div className="two wide field" style={{marginTop: '1.4rem', marginLeft: '5rem'}}>
            <button className={this.state.btnClass} style={{backgroundColor: '#1eb2a6'}} onClick={this.onFormSubmit}>
              {this.state.btnName}
            </button>
          </div>
        </div>
      </form>
    );
  }
}

export default MyForm;