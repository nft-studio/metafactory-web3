const HDWalletProvider = require("@truffle/hdwallet-provider");
const web3 = require("web3");
require('dotenv').config()
const MNEMONIC = process.env.GANACHE_MNEMONIC;
const NFT_CONTRACT_ADDRESS = process.env.GANACHE_CONTRACT_ADDRESS;
const OWNER_ADDRESS = process.env.GANACHE_OWNER_ADDRESS;
const NFT_CONTRACT_ABI = require('../abi.json')
const argv = require('minimist')(process.argv.slice(2));
const fs = require('fs')

async function main() {
    const configs = JSON.parse(fs.readFileSync('./deployed/' + argv._ + '.json').toString())
    if (configs.owner_mnemonic !== undefined) {
        const provider = new HDWalletProvider(
            configs.owner_mnemonic,
            configs.provider
        );
        const web3Instance = new web3(provider);

        const nftContract = new web3Instance.eth.Contract(
            NFT_CONTRACT_ABI,
            configs.contract_address, { gasLimit: "5000000" }
        );

        const name = await nftContract.methods.name().call();
        const symbol = await nftContract.methods.symbol().call();
        const owner = await nftContract.methods.owner().call();
        console.log('|* NFT DETAILS *|')
        console.log('>', name, symbol, '<')
        console.log('Owner is', owner)

        try {
            console.log('Trying minting NFT...')
            const result = await nftContract.methods
                .fixPrice("1000000000000000000")
                .send({ from: configs.owner_address });
            console.log("Price fixed! Transaction: " + result.transactionHash);
            console.log(result)
        } catch (e) {
            console.log(e)
        }
    } else {
        console.log('Please provide `owner_mnemonic` first.')
    }

}

if (argv._ !== undefined) {
    main();
} else {
    console.log('Provide a deployed contract first.')
}