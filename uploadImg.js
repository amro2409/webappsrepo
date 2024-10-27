import { https } from 'firebase-functions';
import express from 'express';
import { urlencoded, json } from "body-parser";
import uuidv4 from 'uuid/v4';
const uuid = uuidv4();

import { tmpdir } from 'os';
import { join } from "path";
const cors = require('cors')({ origin: true })
import Busboy from 'busboy';
import { createWriteStream } from 'fs';
import { initializeApp, credential as _credential, storage } from "firebase-admin";


var serviceAccount = {
    "type": "service_account",
    "project_id": "xxxxxx",
    "private_key_id": "xxxxxx",
    "private_key": "-----BEGIN PRIVATE KEY-----\jr5x+4AvctKLonBafg\nElTg3Cj7pAEbUfIO9I44zZ8=\n-----END PRIVATE KEY-----\n",
    "client_email": "xxxx@xxxx.iam.gserviceaccount.com",
    "client_id": "xxxxxxxx",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-5rmdm%40xxxxx.iam.gserviceaccount.com"
}

initializeApp({
    credential: _credential.cert(serviceAccount),
    storageBucket: "xxxxx-xxxx" // use your storage bucket name
});


const app = express();
app.use(urlencoded({ extended: false }));
app.use(json());
app.post('/uploadFile', (req, response) => {
    response.set('Access-Control-Allow-Origin', '*');
    const busboy = new Busboy({ headers: req.headers })
    let uploadData = null
    busboy.on('file', (fieldname, file, filename, encoding, mimetype) => {
        const filepath = join(tmpdir(), filename)
        uploadData = { file: filepath, type: mimetype }
        console.log("-------------->>",filepath)
        file.pipe(createWriteStream(filepath))
    })

    busboy.on('finish', () => {
        const bucket = storage().bucket();
        bucket.upload(uploadData.file, {
            uploadType: 'media',
            metadata: {
                metadata: { firebaseStorageDownloadTokens: uuid,
                    contentType: uploadData.type,
                },
            },
        })

            .catch(err => {
                res.status(500).json({
                    error: err,
                })
            })
    })
    busboy.end(req.rawBody)
});




export const widgets = https.onRequest(app);
