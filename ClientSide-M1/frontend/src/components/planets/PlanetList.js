import React, { Component } from "react";
import Planet from "./Planet";

class PlanetList extends Component {
  onDelete = id => {
    this.props.onDelete(id);
  };

  onEdit = id => {
    this.props.onEdit(id);
  };

  render() {
    const { planets } = this.props;
    return (
      <div className="data">
        <table className="ui celled table">
          <thead>
            <tr>
              <th style={{ width: "50px", textAlign: "center" }}>#</th>
              <th>Name</th>
              <th>Type</th>
              <th>isDeleted</th>
              <th style={{ width: "148px" }}>Action</th>
            </tr>
          </thead>

          <tbody>
            {planets
              //.filter(planet => !planet.isDeleted) // Uncomment if you want to exclude deleted planets
              .map(planet => (
                <Planet
                  key={planet.id}
                  planet={planet}
                  onDelete={this.onDelete}
                  onEdit={this.onEdit}
                />
              ))}
          </tbody>

        </table>
      </div>
    );
  }
}

export default PlanetList;
