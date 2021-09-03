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
    const nftContract = new web3Instance.eth.Contract(
      NFT_CONTRACT_ABI,
      configs.contract_address
    );
    console.log('Disabling proxy in contract: ' + argv._)
    console.log('--')
    console.log('CONTRACT ADDRESS IS:', configs.contract_address)
    await nftContract.methods.disableProxyMinting().send({ from: configs.umi.address })
    const proxy = await nftContract.methods.proxyMintingEnabled().call();
    console.log('Proxy enabled:', proxy)

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