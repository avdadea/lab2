import React, { Component } from "react";

class MyForm extends Component {
  state = {
    form: { name: "", number:"", birthYear:"",team_id: "", isEdit: false },
    btnName: "Save",
    btnClass: "ui primary button submit-button",
    teams: [] // Add this state
  };

  async componentDidMount() {
    // Fetch planets and update the state
    if (this.props.teams) {
      this.setState({ teams: this.props.teams });
    }
  }

  componentDidUpdate(prevProps) {
    if (prevProps.player !== this.props.player && !this.isEmptyObj(this.props.player)) {
      this.setState({
        form: { ...this.props.player, isEdit: true },
        btnName: "Update",
        btnClass: "ui orange button submit-button"
      });
    }
    if (prevProps.teams !== this.props.teams) {
      this.setState({ teams: this.props.teams });
    }
  }

  isEmptyObj(obj) {
    return Object.entries(obj).length === 0 && obj.constructor === Object;
  }

  onFormSubmit = event => {
    event.preventDefault();

    if (this.formValidation()) {
      this.props.onFormSubmit(this.state.form);

      this.setState({
        btnName: "Save",
        btnClass: "ui primary button submit-button"
      });

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
    if (this.state.form.name === "") {
      alert("Enter name");
      return false;
    }
    if (this.state.form.number === "") {
      alert("Enter number");
      return false;
    }
    if (this.state.form.birthYear === "") {
      alert("Enter Birth Year");
      return false;
    }

    if (this.state.form.team_id === "") {
      alert("Select a team");
      return false;
    }

    return true;
  };

  clearFormFields = () => {
    this.setState({
      form: { name: "", number:"",birthYear:"",team_id: "", isEdit: false }
    });
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
            <label>Number</label>
            <input
              type="text"
              name="number"
              placeholder="Number"
              onChange={this.handleChange}
              value={this.state.form.number}
            />
          </div>
          <div className="four wide field">
            <label>BirthYear</label>
            <input
              type="text"
              name="birthYear"
              placeholder="BirthYear"
              onChange={this.handleChange}
              value={this.state.form.birthYear}
            />
          </div>


          <div className="six wide field">
            <label>Team</label>
            <select
              name="team_id"
              onChange={this.handleChange}
              value={this.state.form.team_id}
            >
              <option value="">Select a team</option>
              {this.state.teams.map(team => (
                <option key={team.id} value={team.id}>
                  {team.id}
                </option>
              ))}
            </select>
          </div>

          <div className="two wide field" style={{ marginTop: '1.4rem', marginLeft: '5rem' }}>
            <button className={this.state.btnClass} style={{ backgroundColor: '#1eb2a6' }} onClick={this.onFormSubmit}>
              {this.state.btnName}
            </button>
          </div>
        </div>
      </form>
    );
  }
}

export default MyForm;
