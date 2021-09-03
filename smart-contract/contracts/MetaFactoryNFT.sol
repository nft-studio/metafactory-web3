// SPDX-License-Identifier: MIT
pragma solidity ^0.8.6;

import "@openzeppelin/contracts/token/ERC721/ERC721.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721Burnable.sol";
import "@openzeppelin/contracts/access/Ownable.sol";
import "@openzeppelin/contracts/utils/Counters.sol";

/**
 * @title MetafactoryNFT
 * MetafactoryNFT - Base smart contract for UMi ERC-721 Standards
 */
contract MetafactoryNFT is ERC721, ERC721URIStorage, ERC721Burnable, Ownable {
    mapping(string => address) private _creatorsMapping;
    mapping(uint256 => string) private _tokenIdsMapping;
    mapping(string => uint256) private _tokenIdsToHashMapping;
    address openseaProxyAddress;
    address umiProxyAddress;
    string public contract_ipfs_json;
    string private baseURI;
    using Counters for Counters.Counter;
    Counters.Counter private _tokenIdCounter;
    string public notrevealed_nft = "00000000000000000000000000000000000";
    uint256 mintingPrice = 50 finney;

    constructor(
        address _openseaProxyAddress,
        string memory _name,
        string memory _ticker,
        string memory _contract_ipfs,
        address _umiProxyAddress,
        string memory _base_uri
    ) ERC721(_name, _ticker) {
        openseaProxyAddress = _openseaProxyAddress;
        umiProxyAddress = _umiProxyAddress;
        contract_ipfs_json = _contract_ipfs;
        baseURI = _base_uri;
    }

    function _baseURI() internal override view returns (string memory) {
        return baseURI;
    }

    function _burn(uint256 _tokenId) internal override(ERC721, ERC721URIStorage) {
        require(burningEnabled, "MetafactoryNFT: Burning is disabled");
        super._burn(_tokenId);
    }

    function tokenURI(uint256 _tokenId)
        public
        view
        override(ERC721, ERC721URIStorage)
        returns (string memory)
    {
        return super.tokenURI(_tokenId);
    }

    function contractURI() public view returns (string memory) {
        return contract_ipfs_json;
    }

    function nftExists(string memory tokenHash) internal view returns (bool) {
        address owner = _creatorsMapping[tokenHash];
        return owner != address(0);
    }

    function returnTokenIdByHash(string memory tokenHash)
        public
        view
        returns (uint256)
    {
        return _tokenIdsToHashMapping[tokenHash];
    }

    function returnTokenURI(uint256 tokenId)
        public
        view
        returns (string memory)
    {
        return _tokenIdsMapping[tokenId];
    }

    function returnCreatorByNftHash(string memory hash)
        public
        view
        returns (address)
    {
        return _creatorsMapping[hash];
    }

    function canMint(string memory _tokenURI) internal view returns (bool) {
        require(!nftExists(_tokenURI), "MetafactoryNFT: Trying to mint existent nft");
        return true;
    }

    function buyNFT()
        public
        payable
        returns (uint256)
    {
        require(msg.value == mintingPrice, 'MetafactoryNFT: Amount should be exactly the minting cost');
        _tokenIdCounter.increment();
        uint256 newTokenId = _tokenIdCounter.current();
        _mint(_to, newTokenId);
        _tokenIdsMapping[newTokenId] = notrevealed_nft;
        return newTokenId;
    }

    function revealNFT(string memory _tokenURI, uint256 _tokenId)
        public
        onlyOwner
    {
        require(canMint(_tokenURI), "MetafactoryNFT: Can't mint token");
        require(_tokenIdsMapping[_tokenId] == notrevealed_nft, "MetafactoryNFT: Token revealed yet");
        _setTokenURI(newTokenId, _tokenURI);
        _creatorsMapping[_tokenURI] = msg.sender;
        _tokenIdsMapping[_tokenId] = _tokenURI;
        _tokenIdsToHashMapping[_tokenURI] = tokenId;
    }

    function fixPrice(uint256 newPrice) public onlyOwner {
        mintingPrice = newPrice;
    }

    function fixContractDescription(string memory newDescription) public onlyOwner {
        contract_ipfs_json = newDescription;
    }

    function fixLootboxMetadata(string memory newMetadata) public onlyOwner {
        notrevealed_nft = newMetadata;
    }

    function getBalance() public view returns (uint256) {
        return address(this).balance;
    }

    function withdrawEther() public onlyOwner {
        require(address(this).balance > 0, 'MetafactoryNFT: Nothing to withdraw!');
        msg.sender.transfer(address(this).balance);
    }

    function totalSupply() public view returns (uint256) {
        return _tokenIdCounter.current();
    }

    /**
     * Override isApprovedForAll to whitelist proxy accounts
     */
    function isApprovedForAll(address _owner, address _operator)
        public
        override
        view
        returns (bool isOperator)
    {
        // Adding another burning address
        if (_owner == address(0x000000000000000000000000000000000000dEaD)) {
            return false;
        }
        // Approving for Opensea address
        if (
            _operator == address(openseaProxyAddress)
        ) {
            return true;
        }

        return super.isApprovedForAll(_owner, _operator);
    }
}
