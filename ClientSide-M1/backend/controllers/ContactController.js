// controllers/ContactController.js
const Contact = require("../models/ContactModel"); // Update the path

const contactUs = (req, res) => {
  const { fullName, subject, emailAddress, message } = req.body;

  // Create a new contact instance
  const contact = new Contact({
    fullName,
    subject,
    emailAddress,
    message,
  });

  // Save the contact to the database
  contact
    .save()
    .then((savedContact) => {
      // Send a success response
      res.status(201).json(savedContact);
    })
    .catch((error) => {
      // Handle errors
      res.status(400).json({ error: error.message });
    });
};

const getAllEmails = (req, res) => {
  // Find all contacts
  Contact.find()
    .then((contacts) => {
      // Send a success response with all contact details
      res.status(200).json(contacts);
    })
    .catch((error) => {
      // Handle errors
      res.status(400).json({ error: error.message });
    });
};

const deleteEmail = (req, res) => {
  console.log("deleteEmail function called");
  // Extract the id from the request parameters
  const { _id } = req.params;

  console.log(`Attempting to delete contact with id: ${_id}`); // Add this line

  // Delete the contact with the given id
  Contact.findByIdAndDelete(_id)
    .then((deletedContact) => {
      if (deletedContact) {
        console.log(`Deleted contact with id: ${_id}`); // Add this line
        // Send a success response
        res.status(200).json({ message: "Contact deleted successfully." });
      } else {
        console.log(`No contact found with id: ${_id}`); // Add this line
        // Handle case when no contact was found
        res
          .status(404)
          .json({ message: "No contact found with the given id." });
      }
    })
    .catch((error) => {
      console.log(`Error deleting contact with id: ${_id}`); // Add this line
      console.error(error); // Change this line to log the entire error object
      // Handle errors
      res.status(400).json({ error: error.message });
    });
};



module.exports = {
  contactUs,
  getAllEmails,
  deleteEmail,
};