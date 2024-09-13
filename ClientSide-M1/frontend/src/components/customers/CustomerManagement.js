import React, { Component } from "react";
import axios from "axios";
import MyForm from "./MyForm";
import CustomerList from "./CustomerList";
import Loader from "./Loader";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom"; // Import the necessary components
import "./style.css";

class CustomerManagement extends Component {
  state = {
    customers: [],
    loader: false,
    customer: {},
    url: "http://127.0.0.1:8000/api/customers"
  };

  getCustomers = async () => {
    this.setState({ loader: true });
    try {
      const response = await axios.get(this.state.url);
      const customers = response.data.data || []; // Default to an empty array if 'data' is undefined
      this.setState({ customers, loader: false });
    } catch (error) {
      console.error(error);
      this.setState({ loader: false });
    }
  };

  deleteCustomer = async id => {
    this.setState({ loader: true });
    try {
      await axios.delete(`${this.state.url}/${id}`);
      this.getCustomers();
    } catch (e) {
      alert(e.response.status === 404 ? "Customer not found" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  createCustomer = async data => {
    this.setState({ loader: true });
    try {
      await axios.post(this.state.url, {
        first_name: data.first_name,
        last_name: data.last_name,
        email: data.email
      });
      this.getCustomers();
    } catch (e) {
      alert(e.response.status === 500 ? "Email already exists" : "");
    } finally {
      this.setState({ loader: false });
    }
  };

  editCustomer = async data => {
    this.setState({ customer: {}, loader: true });
    try {
      await axios.put(`${this.state.url}/${data.id}`, {
        first_name: data.first_name,
        last_name: data.last_name,
        email: data.email
      });
      this.getCustomers();
    } catch (e) {
      console.log(e.message);
    } finally {
      this.setState({ loader: false });
    }
  };

  componentDidMount() {
    this.getCustomers();
  }

  onDelete = id => {
    this.deleteCustomer(id);
  };

  onEdit = data => {
    this.setState({ customer: data });
  };

  onFormSubmit = data => {
    if (data.isEdit) {
      this.editCustomer(data);
    } else {
      this.createCustomer(data);
    }
  };

  render() {
    return (
      <Router>
        <div>
          
          <div className="ui main container">
            <MyForm
              onFormSubmit={this.onFormSubmit}
              customer={this.state.customer}
            />
            {this.state.loader ? <Loader /> : ""}
            <CustomerList
              customers={this.state.customers}
              onDelete={this.onDelete}
              onEdit={this.onEdit}
            />
          </div>
        </div>
      </Router>
    );
  }
}

export default CustomerManagement;
