import TronWeb from 'tronweb';

const fullNode = 'https://api.trongrid.io';
const solidityNode = 'https://api.trongrid.io';
const eventServer = 'https://api.trongrid.io';

const mode = process.argv[2];         // "sweep"
const fromAddress = process.argv[3];
const privateKey = process.argv[4];
const toAddress = process.argv[5];
const amount = process.argv[6];       // already in SUN (TRX) or 1e6 units (USDT)
const token = process.argv[7];        // TRX | USDT
const usdtContract = process.argv[8] || '';

const tronWeb = new TronWeb(fullNode, solidityNode, eventServer, privateKey);

(async () => {
    try {
        if (mode === 'sweep') {
            let receipt;

            if (token === 'TRX') {
                const tradeobj = await tronWeb.transactionBuilder.sendTrx(
                    toAddress,
                    tronWeb.toBigNumber(amount).toNumber(),
                    fromAddress
                );
                const signedTxn = await tronWeb.trx.sign(tradeobj, privateKey);
                receipt = await tronWeb.trx.sendRawTransaction(signedTxn);
            }

            if (token === 'USDT') {
                const contract = await tronWeb.contract().at(usdtContract);
                const tokenAmount = tronWeb.toBigNumber(amount).toString(10);
                receipt = await contract.transfer(
                    toAddress,
                    tokenAmount
                ).send({
                    feeLimit: 100_000_000
                }, privateKey);
            }

            console.log(JSON.stringify({ success: true, receipt }));
        }
    } catch (e) {
        console.error('server.js sweep error:', e?.message || e);
        if (e?.transaction) console.error('Fail tx:', JSON.stringify(e.transaction, null, 2));
        process.exit(1);
    }
})();
