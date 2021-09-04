// SPDX-License-Identifier: MIT
pragma solidity ^0.8.6;

import "@openzeppelin/contracts/token/ERC721/ERC721.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721Burnable.sol";
import "@openzeppelin/contracts/access/Ownable.sol";
import "@openzeppelin/contracts/utils/Counters.sol";

/**
 * @title MetafactoryNFT
 * MetafactoryNFT
 */
contract MetafactoryNFT is ERC721, ERC721URIStorage, ERC721Burnable, Ownable {
    mapping(string => address) private _creatorsMapping;
    mapping(uint256 => string) private _tokenIdsMapping;
    mapping(string => uint256) private _tokenIdsToHashMapping;
    mapping(uint256 => string) private _tokenIdsToCollectionMapping;
    address openseaProxyAddress;
    string public contract_ipfs_json;
    string private baseURI;
    using Counters for Counters.Counter;
    Counters.Counter private _tokenIdCounter;

    struct collection {
        uint256 mintingPrice;
        uint256 hardCap;
        uint256 minted;
        string lootMetadata;
    }
    mapping(string => collection) public _collections;

    constructor(
        address _openseaProxyAddress,
        string memory _name,
        string memory _ticker,
        string memory _contract_ipfs,
        string memory _base_uri
    ) ERC721(_name, _ticker) {
        openseaProxyAddress = _openseaProxyAddress;
        contract_ipfs_json = _contract_ipfs;
        baseURI = _base_uri;
    }

    function _baseURI() internal override view returns (string memory) {
        return baseURI;
    }

    function _burn(uint256 _tokenId) internal override(ERC721, ERC721URIStorage) {
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

    function buyNFT(string memory _collection)
        public
        payable
        returns (uint256)
    {
        require(_collections[_collection].hardCap > 0, "MetafactoryNFT: Collection doesn't exists");
        require(_collections[_collection].minted < _collections[_collection].hardCap, "MetafactoryNFT: Collection reached hard cap");
        require(msg.value == _collections[_collection].mintingPrice, 'MetafactoryNFT: Amount should be exactly the minting cost');
        _tokenIdCounter.increment();
        _collections[_collection].minted++;
        uint256 newTokenId = _tokenIdCounter.current();
        _mint(msg.sender, newTokenId);
        _setTokenURI(newTokenId, _collections[_collection].lootMetadata);
        _tokenIdsMapping[newTokenId] = _collections[_collection].lootMetadata;
        _tokenIdsToCollectionMapping[newTokenId] = _collection;
        return newTokenId;
    }

    function revealNFT(string memory _tokenURI, uint256 _tokenId)
        public
        onlyOwner
    {
        string memory _collection = _tokenIdsToCollectionMapping[_tokenId];
        require(
            keccak256(abi.encode(_tokenIdsMapping[_tokenId])) == keccak256(abi.encode(_collections[_collection].lootMetadata)),
            "MetafactoryNFT: Token revealed yet");
        require(canMint(_tokenURI), "MetafactoryNFT: Can't mint token");
        _setTokenURI(_tokenId, _tokenURI);
        _creatorsMapping[_tokenURI] = msg.sender;
        _tokenIdsMapping[_tokenId] = _tokenURI;
        _tokenIdsToHashMapping[_tokenURI] = _tokenId;
    }

    function setupCollection(string memory _collection, uint256 _price, uint256 _hardCap, string memory _lootMetadata) public onlyOwner {
        // Can't edit hard cap if minting is done, this won't be fair for users.
        if(_collections[_collection].minted == 0) {
            _collections[_collection].hardCap = _hardCap;
        }
        _collections[_collection].lootMetadata = _lootMetadata;
        _collections[_collection].mintingPrice = _price;
    }

    function returnCollection(string memory _collection) public returns (collection memory){
        return _collections[_collection];
    }

    function fixContractDescription(string memory newDescription) public onlyOwner {
        contract_ipfs_json = newDescription;
    }

    function getBalance() public view returns (uint256) {
        return address(this).balance;
    }

    function withdrawEther() public onlyOwner {
        uint256 balance = address(this).balance;
        require(balance > 0, 'MetafactoryNFT: Nothing to withdraw!');
        payable(msg.sender).transfer(balance);
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
