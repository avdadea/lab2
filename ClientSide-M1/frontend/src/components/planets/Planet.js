import React, { Component } from "react";

class Planet extends Component {
  onDelete = () => {
    this.props.onDelete(this.props.planet.id);
  };

  onEdit = () => {

    this.props.onEdit(this.props.planet);
  };

  render() {
    const { id, name, type, isDeleted } = this.props.planet;
    return (
      <tr>
        <td style={{ textAlign: "center" }}>{id}</td>
        <td>{name}</td>
        <td>{type}</td>
        <td>{isDeleted === 1 ? 'True' : 'False'}</td> {/* Display as True/False */}
        <td>
          <button className="mini ui blue button" onClick={this.onEdit}>
            Edit
          </button>
          <button className="mini ui red button" onClick={this.onDelete}>
            Delete
          </button>
        </td>
      </tr>
    );
  }
}

export default Planet;