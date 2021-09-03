const argv = require('minimist')(process.argv.slice(2));
const fs = require('fs')
const child_process = require('child_process')

async function deploy() {
    try {
        const configs = JSON.parse(fs.readFileSync('./deployed/' + argv._ + '.json').toString())
        if (
            configs.network !== undefined &&
            configs.proxy_address !== undefined &&
            configs.proxy_mnemonic !== undefined &&
            configs.owner_address !== undefined &&
            configs.contract !== undefined &&
            configs.contract.name !== undefined &&
            configs.contract.ticker !== undefined &&
            configs.contract.contractIPFS !== undefined &&
            configs.burning_enabled !== undefined &&
            configs.proxy_enabled !== undefined &&
            configs.provider !== undefined &&
            configs.contract.baseURI !== undefined &&
            configs.umi !== undefined
        ) {

            console.log('Removing existing build..')
            child_process.execSync('sudo rm -rf build')

            let output
            if (argv.debug !== undefined) {
                output = { stdio: 'inherit' }
            }

            let minter_mnemonic = configs.umi.mnemonic
            if (configs.proxy_enabled) {
                minter_mnemonic = configs.proxy_mnemonic
            }

            console.log('Deploying contract..')
            let out = child_process.execSync('sudo PROVIDER="' + configs.provider + '" MNEMONIC="' + minter_mnemonic + '" BASEURI="' + configs.contract.baseURI + '" DESCRIPTION="' + configs.contract.contractIPFS + '" TICKER="' + configs.contract.ticker + '" NAME="' + configs.contract.name + '" PROXY="' + configs.proxy_address + '" PROXY_ENABLED=' + configs.proxy_enabled + ' BURNING_ENABLED=' + configs.burning_enabled + ' OWNER="' + configs.owner_address + '" truffle deploy --network ' + configs.network + ' --reset', output)

            // Extracting address
                if(out !== null){
                out = out.toString()
                let head = out.split('CONTRACT ADDRESS IS*||*')
                let foot = head[1].split('*||*')
                const address = foot[0]
                console.log('Deployed address is: ' + address)
                configs.contract_address = address
                console.log('Saving address in config file..')
                fs.writeFileSync('./deployed/' + argv._ + '.json', JSON.stringify(configs, null, 4))
                console.log('--')
            }

            console.log('Extrating ABI..')
            child_process.execSync('sudo npm run extract-abi')
            console.log('--')

            console.log('All done, exiting!')
            process.exit();
        } else {
            console.log('Config file missing.')
        }
    } catch (e) {
        console.log(e.message)
        process.exit()
    }
}

if (argv._ !== undefined) {
    deploy();
} else {
    console.log('Provide a config first.')
}