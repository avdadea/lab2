import React, { Component } from "react";

class Team extends Component {
  onDelete = () => {
    // console.log('customer ', this.props.customer.id);
    this.props.onDelete(this.props.team.id);
  };

  onEdit = () => {
    // console.log('customer ', this.props.customer.id);
    this.props.onEdit(this.props.team);
  };

  render() {
    const { id, name } = this.props.team;
    return (
      <tr>
        <td style={{ textAlign: "center" }}>{id}</td>
        <td>{name}</td>
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

export default Team;