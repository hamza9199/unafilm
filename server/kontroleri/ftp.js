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


async function deleteFromFrontend(filename) {
  const client = new ftp.Client();
  try {
    await client.access({
      host: "dedi5675.your-server.de",
      user: "unafilm",
      password: "wb85L56YNj1IlDK9",
      port: 21,
      secure: true
    });

    await client.cd("/public_html/klijent/uploads");
    await client.remove(filename);
    console.log("Obrisana stara slika:", filename);
  } catch (err) {
    console.error("Greška pri brisanju slike sa FTP-a:", err.message);
  } finally {
    client.close();
  }
}

module.exports = { uploadToFrontend, deleteFromFrontend };


