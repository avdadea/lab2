const express = require('express')
const router = express.Router()
const {contactUs, getAllEmails, deleteEmail} = require('../controllers/ContactController')


router.delete('/email/:_id', deleteEmail);
router.post('/', contactUs);
router.get('/getAllEmails', getAllEmails);

module.exports = router