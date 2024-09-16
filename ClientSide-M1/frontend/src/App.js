import React from "react";
import "./App.css";
import Header from "./components/common/header/Header";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom"; // Switch -> Routes

import About from "./components/about/About";
import CourseHome from "./components/allcourses/CourseHome";
import Team from "./components/team/Team";
import Pricing from "./components/pricing/Pricing";
import Blog from "./components/blog/Blog";
import Contact from "./components/contact/Contact";
import Footer from "./components/common/footer/Footer";
import Home from "./components/home/Home";
import CustomerManagement from "./components/customers/CustomerManagement.js";
import PlanetManagement from "./components/planets/PlanetManagement.js";
import SatelliteManagement from "./components/satellites/SatelliteManagement.js";
import TeamManagement from "./components/teams/TeamManagement.js";
import PlayerManagement from "./components/players/PlayerManagement.js";

import Employees from './components/employees/Employees';
import AddEmployeePage from "./components/employees/AddEmployeePage";
import EditEmployeePage from "./components/employees/EditEmployeePage";

import ContractsList from "./components/contracts/ContractsList";
import AddContractPage from "./components/contracts/AddContractPage";
import EditContractPage from "./components/contracts/EditContractPage";



function App() {
  return (
    <Router>
      <Header />
      <Routes> {/* Switch -> Routes */}
        <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} />
        <Route path="/courses" element={<CourseHome />} />
        <Route path="/team" element={<Team />} />
        <Route path="/pricing" element={<Pricing />} />
        <Route path="/journal" element={<Blog />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="/customers" element={<CustomerManagement />} />
        <Route path="/planets" element={<PlanetManagement />} />
        <Route path="/satellites" element={<SatelliteManagement />} />
        <Route path="/teams" element={<TeamManagement />} />
        <Route path="/players" element={<PlayerManagement />} />

        <Route path="/employees" element={<Employees />} />
        <Route path="/add-employee" element={<AddEmployeePage />} />
        <Route path="/edit-employee/:id" element={<EditEmployeePage />} />

        <Route path="/contracts" element={<ContractsList />} /> {/* Movie listing page */}
        <Route path="/add-contract" element={<AddContractPage />} /> {/* Add Movie page */}
        <Route path="/edit-contract/:id" element={<EditContractPage />} /> {/* Edit Movie page */}

      </Routes>
      <Footer />
    </Router>
  );
}

export default App;
