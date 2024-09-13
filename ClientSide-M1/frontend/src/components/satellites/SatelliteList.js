import React, { Component } from "react";
import Satellite from "./Satellite";

class SatelliteList extends Component {
  onDelete = id => {
    this.props.onDelete(id);
  };

  onEdit = satellite => {
    this.props.onEdit(satellite);
  };

  render() {
    const satellites = Array.isArray(this.props.satellites) ? this.props.satellites : [];

    console.log("Satellites data:", satellites); // Debugging statement

    return (
      <div className="data">
        <table className="ui celled table">
          <thead>
            <tr>
              <th style={{ width: "50px", textAlign: "center" }}>#</th>
              <th>Name</th>
              <th>isDeleted</th> {/* Fixed header column */}
              <td>PlanetId</td>
              <th style={{ width: "148px" }}>Action</th>
            </tr>
          </thead>

          <tbody>
            {satellites.map(satellite => {
              return (
                <Satellite
                  key={satellite.id}
                  satellite={satellite}
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

export default SatelliteList;
