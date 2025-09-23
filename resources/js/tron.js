import TronWeb from 'tronweb';

const tronWeb = new TronWeb.TronWeb({   // 👈 wrap inside TronWeb
  fullHost: 'https://api.trongrid.io'
});

async function createAccount() {
  const account = await tronWeb.createAccount();
  console.log(JSON.stringify(account));
}

createAccount();
