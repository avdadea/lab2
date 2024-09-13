import React, { Component } from "react";
import axios from "axios";
import MyForm from "./MyForm";
import PlanetList from "./PlanetList";
import Loader from "./Loader";
import { BrowserRouter as Router } from "react-router-dom";
import "./style.css";
import SearchComponent from "./SearchComponent";

class PlanetManagement extends Component {
  state = {
    planets: [],
    loader: false,
    planet: {},
    url: "http://127.0.0.1:8000/api/planets"
  };

  getPlanets = async (params = {}) => {
    this.setState({ loader: true });
    try {
      const response = await axios.get(this.state.url, { params });
      const planets = response.data.data || [];
      this.setState({ planets, loader: false });
    } catch (error) {
      console.error(error);
      this.setState({ loader: false });
    }
  };

  deletePlanet = async id => {
    this.setState({ loader: true });
    try {
      await axios.delete(`${this.state.url}/${id}`);
      this.getPlanets();
    } catch (e) {
      alert(e.response.status === 404 ? "Planet not found" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  createPlanet = async data => {
    this.setState({ loader: true });
    try {
      await axios.post(this.state.url, {
        name: data.name,
        type: data.type,
        isDeleted: data.isDeleted
      });
      this.getPlanets();
    } catch (e) {
      alert(e.response.status === 500 ? "Email already exists" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  editPlanet = async data => {
    this.setState({ planet: {}, loader: true });
    try {
      await axios.put(`${this.state.url}/${data.id}`, {
        name: data.name,
        type: data.type,
        isDeleted: data.isDeleted
      });
      this.getPlanets();
    } catch (e) {
      console.log(e.message);
    } finally {
      this.setState({ loader: false });
    }
  };

  componentDidMount() {
    this.getPlanets();
  }

  onDelete = id => {
    this.deletePlanet(id);
  };

  onEdit = data => {
    this.setState({ planet: data });
  };

  onFormSubmit = data => {
    if (data.isEdit) {
      this.editPlanet(data);
    } else {
      this.createPlanet(data);
    }
  };

  handleSearch = (data) => {
    this.setState({ planets: data });
  };

  render() {
    return (
      <Router>
        <div>
          <div className="ui main container">
            <h1>Add or Edit</h1>
            <MyForm
              onFormSubmit={this.onFormSubmit}
              planet={this.state.planet}
            />

            <div className="App">
              <h1>Search </h1>
              <SearchComponent onSearch={this.handleSearch} />
            </div>
            {this.state.loader ? <Loader /> : ""}
            <PlanetList
              planets={this.state.planets}
              onDelete={this.onDelete}
              onEdit={this.onEdit}
            />
          </div>
        </div>
      </Router>
    );
  }
}

export default PlanetManagement;
