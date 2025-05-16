const ftp = require("basic-ftp");
const path = require("path");
const fs = require("fs");


async function uploadToFrontend(localPath, remoteFileName) {
  const client = new ftp.Client();
  try {
    await client.access({
      host: "dedi5675.your-server.de",
      user: "unafilm",
      password: "wb85L56YNj1IlDK9",
      port: 21,
      secure: false
    });

    await client.ensureDir("/public_html/klijent/uploads"); 
    await client.uploadFrom(localPath, remoteFileName);
  } catch (err) {
    console.error("FTP greška:", err);
  } finally {
    client.close();
  }
}

module.exports = { uploadToFrontend };