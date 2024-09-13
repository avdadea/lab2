import React, { Component } from "react";
import axios from "axios";
import MyForm from "./MyForm";
import PlayerList from "./PlayerList";
import Loader from "./Loader";
import { BrowserRouter as Router } from "react-router-dom";
import "./style.css";
import SearchComponent from "./SearchComponent";

class PlayerManagement extends Component {
  state = {
    players: [],
    teams: [],
    loader: false,
    player: {},
    url: "http://127.0.0.1:8000/api/players",
    teamUrl: "http://127.0.0.1:8000/api/teams"
  };

  getPlayers = async () => {
    this.setState({ loader: true });
    try {
      const response = await axios.get(this.state.url);
      console.log("API Response:", response.data); // Debugging statement
      
      // Extract the array from the paginated response
      const players = Array.isArray(response.data.data.data) ? response.data.data.data : [];
      this.setState({ players, loader: false });
    } catch (error) {
      console.error(error);
      this.setState({ loader: false });
    }
  };

  getTeams = async () => {
    try {
      const response = await axios.get(this.state.teamUrl);
      this.setState({ teams: response.data.data || [] });
    } catch (error) {
      console.error(error);
    }
  };

  deletePlayer = async id => {
    this.setState({ loader: true });
    try {
      await axios.delete(`${this.state.url}/${id}`);
      this.getPlayers();
    } catch (e) {
      alert(e.response.status === 404 ? "Player not found" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  createPlayer = async data => {
    this.setState({ loader: true });
    try {
      await axios.post(this.state.url, {
        name: data.name,
        number:data.number,
        birthYear:data.birthYear,
        team_id: data.team_id
      });
      this.getPlayers();
    } catch (e) {
      alert(e.response.status === 500 ? "Player already exists" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  editPlayer = async data => {
    this.setState({ player: {}, loader: true });
    try {
      await axios.put(`${this.state.url}/${data.id}`, {
        name: data.name, // Fixed field names
        number:data.number,
        birthYear:data.birthYear,
        team_id: data.team_id
      });
      this.getPlayers();
    } catch (e) {
      console.log(e.message);
    } finally {
      this.setState({ loader: false });
    }
  };

  componentDidMount() {
    this.getPlayers();
    this.getTeams(); // Fetch planets when the component mounts
  }

  onDelete = id => {
    this.deletePlayer(id);
  };

  onEdit = data => {
    this.setState({ player: data });
  };

  onFormSubmit = data => {
    if (data.isEdit) {
      this.editPlayer(data);
    } else {
      this.createPlayer(data);
    }
  };

  // handleSearch = (data) => {
  //   const satellites = Array.isArray(data) ? data : [];
  //   this.setState({ satellites });
  // };

  handleSearch = (data) => {
    console.log('Search Results:', data); // Check what data is being passed to this method
    const players = Array.isArray(data.data) ? data.data : [];
    this.setState({ players });
  };
  

  render() {
    return (
      <Router>
        <div>
          <div className="ui main container">
            <h1>Add or Edit</h1>
            <MyForm
              onFormSubmit={this.onFormSubmit}
              player={this.state.player}
              teams={this.state.teams} // Pass planets data here
            />
            
            {/* <div className="App">
              <h1>Search</h1>
              <SearchComponent onSearch={this.handleSearch} />
            </div> */}

            {this.state.loader ? <Loader /> : ""}
            <PlayerList
              players={this.state.players} // Ensure this is updated correctly
              onDelete={this.onDelete}
              onEdit={this.onEdit}
            />
          </div>
        </div>
      </Router>
    );
  }
}

export default PlayerManagement;
