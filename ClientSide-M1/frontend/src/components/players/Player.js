import React, { Component } from "react";

class Player extends Component {
  onDelete = () => {
    this.props.onDelete(this.props.player.id);
  };

  onEdit = () => {
    this.props.onEdit(this.props.player);
  };

  render() {
    const { id, name, number, birthYear, team_id } = this.props.player;
    return (
      <tr>
        <td style={{ textAlign: "center" }}>{id}</td>
        <td>{name}</td>
        <td>{number}</td>
        <td>{birthYear}</td>
        <td>{team_id}</td>
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

export default Player;
