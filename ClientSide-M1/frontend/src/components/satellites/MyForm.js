import React, { Component } from "react";

class MyForm extends Component {
  state = {
    form: { name: "", isDeleted: false, planet_id: "", isEdit: false },
    btnName: "Save",
    btnClass: "ui primary button submit-button",
    planets: [] // Add this state
  };

  async componentDidMount() {
    // Fetch planets and update the state
    if (this.props.planets) {
      this.setState({ planets: this.props.planets });
    }
  }

  componentDidUpdate(prevProps) {
    if (prevProps.satellite !== this.props.satellite && !this.isEmptyObj(this.props.satellite)) {
      this.setState({
        form: { ...this.props.satellite, isEdit: true },
        btnName: "Update",
        btnClass: "ui orange button submit-button"
      });
    }
    if (prevProps.planets !== this.props.planets) {
      this.setState({ planets: this.props.planets });
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

    if (this.state.form.planet_id === "") {
      alert("Select a planet");
      return false;
    }

    return true;
  };

  clearFormFields = () => {
    this.setState({
      form: { name: "", planet_id: "", isEdit: false }
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

          <div className="six wide field">
            <label>Planet</label>
            <select
              name="planet_id"
              onChange={this.handleChange}
              value={this.state.form.planet_id}
            >
              <option value="">Select a planet</option>
              {this.state.planets.map(planet => (
                <option key={planet.id} value={planet.id}>
                  {planet.id}
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
