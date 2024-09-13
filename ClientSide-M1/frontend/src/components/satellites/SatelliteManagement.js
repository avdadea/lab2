import React, { Component } from "react";
import axios from "axios";
import MyForm from "./MyForm";
import SatelliteList from "./SatelliteList";
import Loader from "./Loader";
import { BrowserRouter as Router } from "react-router-dom";
import "./style.css";
import SearchComponent from "./SearchComponent";

class SatelliteManagement extends Component {
  state = {
    satellites: [],
    planets: [],
    loader: false,
    satellite: {},
    url: "http://127.0.0.1:8000/api/satellites",
    planetUrl: "http://127.0.0.1:8000/api/planets"
  };

  getSatellites = async () => {
    this.setState({ loader: true });
    try {
      const response = await axios.get(this.state.url);
      console.log("API Response:", response.data); // Debugging statement
      
      // Extract the array from the paginated response
      const satellites = Array.isArray(response.data.data.data) ? response.data.data.data : [];
      this.setState({ satellites, loader: false });
    } catch (error) {
      console.error(error);
      this.setState({ loader: false });
    }
  };

  getPlanets = async () => {
    try {
      const response = await axios.get(this.state.planetUrl);
      this.setState({ planets: response.data.data || [] });
    } catch (error) {
      console.error(error);
    }
  };

  deleteSatellite = async id => {
    this.setState({ loader: true });
    try {
      await axios.delete(`${this.state.url}/${id}`);
      this.getSatellites();
    } catch (e) {
      alert(e.response.status === 404 ? "Satellite not found" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  createSatellite = async data => {
    this.setState({ loader: true });
    try {
      await axios.post(this.state.url, {
        name: data.name,
        isDeleted: data.isDeleted,
        planet_id: data.planet_id
      });
      this.getSatellites();
    } catch (e) {
      alert(e.response.status === 500 ? "Satellite already exists" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  editSatellite = async data => {
    this.setState({ satellite: {}, loader: true });
    try {
      await axios.put(`${this.state.url}/${data.id}`, {
        name: data.name, // Fixed field names
        isDeleted: data.isDeleted,
        planet_id: data.planet_id
      });
      this.getSatellites();
    } catch (e) {
      console.log(e.message);
    } finally {
      this.setState({ loader: false });
    }
  };

  componentDidMount() {
    this.getSatellites();
    this.getPlanets(); // Fetch planets when the component mounts
  }

  onDelete = id => {
    this.deleteSatellite(id);
  };

  onEdit = data => {
    this.setState({ satellite: data });
  };

  onFormSubmit = data => {
    if (data.isEdit) {
      this.editSatellite(data);
    } else {
      this.createSatellite(data);
    }
  };

  // handleSearch = (data) => {
  //   const satellites = Array.isArray(data) ? data : [];
  //   this.setState({ satellites });
  // };

  handleSearch = (data) => {
    console.log('Search Results:', data); // Check what data is being passed to this method
    const satellites = Array.isArray(data.data) ? data.data : [];
    this.setState({ satellites });
  };
  

  render() {
    return (
      <Router>
        <div>
          <div className="ui main container">
            <h1>Add or Edit</h1>
            <MyForm
              onFormSubmit={this.onFormSubmit}
              satellite={this.state.satellite}
              planets={this.state.planets} // Pass planets data here
            />
            
            <div className="App">
              <h1>Search</h1>
              <SearchComponent onSearch={this.handleSearch} />
            </div>

            {this.state.loader ? <Loader /> : ""}
            <SatelliteList
              satellites={this.state.satellites} // Ensure this is updated correctly
              onDelete={this.onDelete}
              onEdit={this.onEdit}
            />
          </div>
        </div>
      </Router>
    );
  }
}

export default SatelliteManagement;
