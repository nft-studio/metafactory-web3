# MetafactoryNFT Smart Contract

This is a smart contract with public minting capability (capped) using collections.

# Test it

In order to test it you simply need to open ganache, fix `deployed/ganache/example.json` with your data and run following commands:

```
yarn
yarn deploy ganache/example
```

After this command you will see automatically updated `contract_address` field in the json.

You can run following tests: 

```
yarn test:collection ganache/example
yarn test:buy ganache/example
yarn test:reveal ganache/example
yarn test:details ganache/example
yarn test:withdraw ganache/example
```