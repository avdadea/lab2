import React, { Component } from "react";
import Team from "./Team";

class TeamList extends Component {
  onDelete = id => {
    // console.log("customer list ", id);
    this.props.onDelete(id);
  };

  onEdit = id => {
    // console.log("customer list ", id);
    this.props.onEdit(id);
  };

  render() {
    const teams = this.props.teams;
    return (
      <div className="data">
        <table className="ui celled table">
          <thead>
            <tr>
              <th style={{ width: "50px", textAlign: "center" }}>#</th>
              <th>Name</th>
              <th style={{ width: "148px" }}>Action</th>
            </tr>
          </thead>

          <tbody>
            {teams.map(team => {
              return (
                <Team
                  key={team.id}
                  team={team}
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

export default TeamList