import React, { Component } from "react";
import axios from "axios";
import MyForm from "./MyForm";
import TeamList from "./TeamList";
import Loader from "./Loader";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom"; // Import the necessary components
import "./style.css";

class TeamManagement extends Component {
  state = {
    teams: [],
    loader: false,
    team: {},
    url: "http://127.0.0.1:8000/api/teams"
  };

  getTeams = async () => {
    this.setState({ loader: true });
    try {
      const response = await axios.get(this.state.url);
      const teams = response.data.data || []; // Default to an empty array if 'data' is undefined
      this.setState({ teams, loader: false });
    } catch (error) {
      console.error(error);
      this.setState({ loader: false });
    }
  };

  deleteTeam = async id => {
    this.setState({ loader: true });
    try {
      await axios.delete(`${this.state.url}/${id}`);
      this.getTeams();
    } catch (e) {
      alert(e.response.status === 404 ? "Team not found" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  createTeam = async data => {
    this.setState({ loader: true });
    try {
      await axios.post(this.state.url, {
        name: data.name,
      });
      this.getTeams();
    } catch (e) {
      alert(e.response.status === 500 ? "Team already exists" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  editTeam = async data => {
    this.setState({ team: {}, loader: true });
    try {
      await axios.put(`${this.state.url}/${data.id}`, {
        name: data.name,
      });
      this.getTeams();
    } catch (e) {
      console.log(e.message);
    } finally {
      this.setState({ loader: false });
    }
  };

  componentDidMount() {
    this.getTeams();
  }

  onDelete = id => {
    this.deleteTeam(id);
  };

  onEdit = data => {
    this.setState({ team: data });
  };

  onFormSubmit = data => {
    if (data.isEdit) {
      this.editTeam(data);
    } else {
      this.createTeam(data);
    }
  };

  render() {
    return (
      <Router>
        <div>
          
          <div className="ui main container">
            <MyForm
              onFormSubmit={this.onFormSubmit}
              team={this.state.team}
            />
            {this.state.loader ? <Loader /> : ""}
            <TeamList
              teams={this.state.teams}
              onDelete={this.onDelete}
              onEdit={this.onEdit}
            />
          </div>
        </div>
      </Router>
    );
  }
}

export default TeamManagement;
