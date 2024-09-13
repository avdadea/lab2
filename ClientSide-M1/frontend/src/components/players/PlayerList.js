import React, { Component } from "react";
import Player from "./Player";

class PlayerList extends Component {
  onDelete = id => {
    this.props.onDelete(id);
  };

  onEdit = player => {
    this.props.onEdit(player);
  };

  render() {
    const players = Array.isArray(this.props.players) ? this.props.players : [];

    console.log("players data:", players); // Debugging statement

    return (
      <div className="data">
        <table className="ui celled table">
          <thead>
            <tr>
              <th style={{ width: "50px", textAlign: "center" }}>#</th>
              <th>Name</th>
              <th>Number</th>
              <th>BirthYear</th>
              <td>TeamId</td>
              <th style={{ width: "148px" }}>Action</th>
            </tr>
          </thead>

          <tbody>
            {players.map(player => {
              return (
                <Player
                  key={player.id}
                  player={player}
                  onDelete={this.onDelete}
                  onEdit={this.onEdit}
                />
              );
            })}
          </tbody>
        </table>
      </div>
    );
  }
}

export default PlayerList;
