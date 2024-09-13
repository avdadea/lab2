import React, { Component } from "react";

class Satellite extends Component {
  onDelete = () => {
    this.props.onDelete(this.props.satellite.id);
  };

  onEdit = () => {
    this.props.onEdit(this.props.satellite);
  };

  render() {
    const { id, name, isDeleted, planet_id } = this.props.satellite;
    return (
      <tr>
        <td style={{ textAlign: "center" }}>{id}</td>
        <td>{name}</td>
        <td>{isDeleted === 1 ? 'True' : 'False'}</td> {/* Display as True/False */}
        <td>{planet_id}</td>
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

export default Satellite;
