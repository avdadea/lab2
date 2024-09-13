import React, { Component } from "react";

class MyForm extends Component {
  state = {
    form: { name: "", isEdit: false },
    btnName: "Save",
    btnClass: "ui primary button submit-button"
  };

  isEmptyObj(obj) {
    return Object.entries(obj).length === 0 && obj.constructor === Object;
  }

  componentDidUpdate(prevProps) {
    if (prevProps !== this.props && !this.isEmptyObj(this.props.team)) {
      this.setState({
        form: { ...this.props.team, isEdit: true },
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
      alert("Enter name");
      return false;
    }
    return true;
  };

  clearFormFields = () => {
    // console.log("clear");
    // change form state
    this.setState({
      form: { name: "", isEdit: false }
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