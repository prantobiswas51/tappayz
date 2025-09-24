import TronWeb from 'tronweb';

const fullNode = 'https://api.trongrid.io';
const solidityNode = 'https://api.trongrid.io';
const eventServer = 'https://api.trongrid.io';

// Arguments from Laravel:
// node server.js sweep USER_ADDR PRIVATE_KEY MAIN_WALLET AMOUNT TRX|USDT [USDT_CONTRACT]
const mode = process.argv[2];         // sweep
const fromAddress = process.argv[3];
const privateKey = process.argv[4];
const toAddress = process.argv[5];
const amount = process.argv[6];       // TRX in SUN or USDT in 1e6 units
const token = process.argv[7];        // TRX or USDT
const usdtContract = process.argv[8] || '';

const tronWeb = new TronWeb(fullNode, solidityNode, eventServer, privateKey);

(async () => {
    try {
        if (mode === 'sweep') {
            let receipt;

            if (token === 'TRX') {
                // Sweep TRX
                const tradeobj = await tronWeb.transactionBuilder.sendTrx(
                    toAddress,
                    parseInt(amount),
                    fromAddress
                );
                const signedTxn = await tronWeb.trx.sign(tradeobj, privateKey);
                receipt = await tronWeb.trx.sendRawTransaction(signedTxn);
            }

            if (token === 'USDT') {
                // Sweep USDT (TRC20)
                const contract = await tronWeb.contract().at(usdtContract);
                receipt = await contract.transfer(
                    toAddress,
                    parseInt(amount)
                ).send({
                    feeLimit: 100_000_000
                }, privateKey);
            }

            console.log(JSON.stringify(receipt));
        }
    } catch (e) {
        console.error('server.js sweep error:', e);
    }
})();
