const express = require('express');
const { submitExcuse, reviewExcuse } = require('../controllers/excuseController');
const router = express.Router();

router.post('/', submitExcuse);
router.put('/:id', reviewExcuse); // Approve/Reject excuse

module.exports = router;