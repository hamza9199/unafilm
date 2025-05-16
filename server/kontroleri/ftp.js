const ftp = require("basic-ftp");
const path = require("path");
const fs = require("fs");


async function uploadToFrontend(localPath, remoteFileName) {
  const client = new ftp.Client();
  client.trackProgress(info => {
    console.log("Upload progress:", info.name, info.bytes);
  });

  try {
    await client.access({
      host: "dedi5675.your-server.de",
      user: "unafilm",
      password: "wb85L56YNj1IlDK9",
      port: 21,
      secure: true
    });

    console.log("Povezan na FTP");

    // Probaj bez /public_html ako je to već root
    await client.ensureDir("/public_html/klijent/uploads");
    console.log("Direktorijum 'uploads' osiguran");

    await client.uploadFrom(localPath, remoteFileName);
    console.log("Upload završen:", remoteFileName);
  } catch (err) {
    console.error("FTP greška:", err);
  } finally {
    client.close();
  }
}

module.exports = { uploadToFrontend };