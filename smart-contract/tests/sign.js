const HDWalletProvider = require("@truffle/hdwallet-provider");
const web3 = require("web3");
require('dotenv').config()
const NFT_CONTRACT_ABI = require('../abi.json')
const argv = require('minimist')(process.argv.slice(2));
const fs = require('fs')

async function main() {
  try {
    const configs = JSON.parse(fs.readFileSync('./deployed/' + argv._ + '.json').toString())
    const provider = new HDWalletProvider(
      configs.umi.mnemonic,
      configs.provider
    );
    const web3Instance = new web3(provider);
    const message = "SomeDataToSign"
    console.log("Signing `" + message + "` with address " + configs.umi.address)
    const signed = await web3Instance.eth.personal.sign(message, configs.umi.address)
    console.log("Signed message: " + signed)
    const verified = await web3Instance.eth.personal.ecRecover(message, signed)
    console.log("Verified address from signature: " + verified)

    process.exit();
  } catch (e) {
    console.log(e.message)
    process.exit();
  }
}

if (argv._ !== undefined) {
  main();
} else {
  console.log('Provide a deployed contract first.')
}