import React from "react";
import "./App.css";
import Header from "./components/common/header/Header";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom"; // Switch -> Routes

import About from "./components/about/About";
import CourseHome from "./components/allcourses/CourseHome";
import Pricing from "./components/pricing/Pricing";
import Blog from "./components/blog/Blog";
import Contact from "./components/contact/Contact";
import Footer from "./components/common/footer/Footer";
import Home from "./components/home/Home";
import CustomerManagement from "./components/customers/CustomerManagement.js";


import Employees from './components/employees/Employees';
import AddEmployeePage from "./components/employees/AddEmployeePage";
import EditEmployeePage from "./components/employees/EditEmployeePage";

import ContractsList from "./components/contracts/ContractsList";
import AddContractPage from "./components/contracts/AddContractPage";
import EditContractPage from "./components/contracts/EditContractPage";


import Explorers from './components/explorers/Explorers';
import AddExplorerPage from "./components/explorers/AddExplorerPage";
import EditExplorerPage from "./components/explorers/EditExplorerPage";


import ExpeditionsList from "./components/expeditions/ExpeditionsList";
import AddExpeditionPage from "./components/expeditions/AddExpeditionPage";
import EditExpeditionPage from "./components/expeditions/EditExpeditionPage";


import Chefs from "./components/chefs/Chefs";
import AddChefPage from "./components/chefs/AddChefPage";
import EditChefPage from "./components/chefs/EditChefPage";

import RecipesList from "./components/recipes/RecipesList.js";
import AddRecipePage from "./components/recipes/AddRecipePage.js";
import EditRecipePage from "./components/recipes/EditRecipePage.js";

import Buildings from "./components/buildings/Buildings.js";
import AddBuildingPage from "./components/buildings/AddBuildingPage.js";
import EditBuildingPage from "./components/buildings/EditBuildingPage.js";

import RenovationsList from "./components/renovations/RenovationsList.js";
import AddRenovationPage from "./components/renovations/AddRenovationPage.js";
import EditRenovationPage from "./components/renovations/EditRenovationPage.js";

import Planets from "./components/planets/Planets.js";
import AddPlanetPage from "./components/planets/AddPlanetPage.js";
import EditPlanetPage from "./components/planets/EditPlanetPage.js";

import SatellitesList from "./components/satellites/SatellitesList.js";
import AddSatellitePage from "./components/satellites/AddSatellitePage.js";
import EditSatellitePage from "./components/satellites/EditSatellitePage.js";

import AssetTypes from "./components/asset_types/AssetTypes.js";
import AddAssetTypePage from "./components/asset_types/AddAssetTypePage.js";
import EditAssetTypePage from "./components/asset_types/EditAssetTypePage.js";

import AssetsList from "./components/assets/AssetsList.js";
import AddAssetPage from "./components/assets/AddAssetPage.js";
import EditAssetPage from "./components/assets/EditAssetPage.js";

import Teams from "./components/teams/Teams.js";
import AddTeamPage from "./components/teams/AddTeamPage.js";
import EditTeamPage from "./components/teams/EditTeamPage.js";

import PlayersList from "./components/players/PlayersList.js";
import AddPlayerPage from "./components/players/AddPlayerPage.js";
import EditPlayerPage from "./components/players/EditPlayerPage.js";

function App() {
  return (
    <Router>
      <Header />
      <Routes> {/* Switch -> Routes */}
        <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} />
        <Route path="/courses" element={<CourseHome />} />
        <Route path="/pricing" element={<Pricing />} />
        <Route path="/journal" element={<Blog />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="/customers" element={<CustomerManagement />} />

        <Route path="/employees" element={<Employees />} />
        <Route path="/add-employee" element={<AddEmployeePage />} />
        <Route path="/edit-employee/:id" element={<EditEmployeePage />} />

        <Route path="/contracts" element={<ContractsList />} /> {/* Movie listing page */}
        <Route path="/add-contract" element={<AddContractPage />} /> {/* Add Movie page */}
        <Route path="/edit-contract/:id" element={<EditContractPage />} /> {/* Edit Movie page */}

        <Route path="/explorers" element={<Explorers />} />
        <Route path="/add-explorer" element={<AddExplorerPage />} />
        <Route path="/edit-explorer/:id" element={<EditExplorerPage />} />
       
        <Route path="/expeditions" element={<ExpeditionsList />} /> {/* Movie listing page */}
        <Route path="/add-expedition" element={<AddExpeditionPage />} /> {/* Add Movie page */}
        <Route path="/edit-expedition/:id" element={<EditExpeditionPage />} /> {/* Edit Movie page */}

        <Route path="/chefs" element={<Chefs />} /> {/* Movie listing page */}
        <Route path="/add-chef" element={<AddChefPage />} /> {/* Add Movie page */}
        <Route path="/edit-chef/:id" element={<EditChefPage />} /> {/* Edit Movie page */}
       
        <Route path="/recipes" element={<RecipesList />} /> {/* Movie listing page */}
        <Route path="/add-recipe" element={<AddRecipePage />} /> {/* Add Movie page */}
        <Route path="/edit-recipe/:id" element={<EditRecipePage />} /> {/* Edit Movie page */}
       
        <Route path="/buildings" element={<Buildings />} /> {/* Movie listing page */}
        <Route path="/add-building" element={<AddBuildingPage />} /> {/* Add Movie page */}
        <Route path="/edit-building/:id" element={<EditBuildingPage />} /> {/* Edit Movie page */}
       
        <Route path="/renovations" element={<RenovationsList />} /> {/* Movie listing page */}
        <Route path="/add-renovation" element={<AddRenovationPage />} /> {/* Add Movie page */}
        <Route path="/edit-renovation/:id" element={<EditRenovationPage />} /> {/* Edit Movie page */}
      
        <Route path="/planets" element={<Planets />} /> {/* Movie listing page */}
        <Route path="/add-planet" element={<AddPlanetPage />} /> {/* Add Movie page */}
        <Route path="/edit-planet/:id" element={<EditPlanetPage />} /> {/* Edit Movie page */}
       
        <Route path="/satellites" element={<SatellitesList />} /> {/* Movie listing page */}
        <Route path="/add-satellite" element={<AddSatellitePage />} /> {/* Add Movie page */}
        <Route path="/edit-satellite/:id" element={<EditSatellitePage />} /> {/* Edit Movie page */}
       
        <Route path="/asset_types" element={<AssetTypes />} /> {/* Movie listing page */}
        <Route path="/add-asset_type" element={<AddAssetTypePage />} /> {/* Add Movie page */}
        <Route path="/edit-asset_type/:id" element={<EditAssetTypePage />} /> {/* Edit Movie page */}
       
        <Route path="/assets" element={<AssetsList />} /> {/* Movie listing page */}
        <Route path="/add-asset" element={<AddAssetPage />} /> {/* Add Movie page */}
        <Route path="/edit-asset/:id" element={<EditAssetPage />} /> {/* Edit Movie page */}
       
        <Route path="/teams" element={<Teams />} /> {/* Movie listing page */}
        <Route path="/add-team" element={<AddTeamPage />} /> {/* Add Movie page */}
        <Route path="/edit-team/:id" element={<EditTeamPage />} /> {/* Edit Movie page */}
       
        <Route path="/players" element={<PlayersList />} /> {/* Movie listing page */}
        <Route path="/add-player" element={<AddPlayerPage />} /> {/* Add Movie page */}
        <Route path="/edit-player/:id" element={<EditPlayerPage />} /> {/* Edit Movie page */}
       
      </Routes>
      <Footer />
    </Router>
  );
}

export default App;
