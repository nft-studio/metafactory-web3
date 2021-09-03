<?php
$permission_level = 2;
include('inc/initialize.php');
$internal_route = 'nfts';
$datatype = 'nfts';
$subroot = '../';

?>
<!DOCTYPE HTML>
<html>
<?php include('layout/header.php'); ?>

<body>
	<div class="bmt-container" id="nfts">
		<?php include('layout/menu.php'); ?>
		<div class="bmt-page-header">
			NFTs
			<?php echo $bmt_locales[$internal_route]['manage']; ?>
			<a href="/bmt/minting" style="float:right; margin:10px 14px 0px 0px" class="bmt-header-button"><i class="fa fa-plus"></i></a>
			<form style="margin: 14px 12px; float:right;display:flex; align-items:center;" @submit.prevent="search()">
				<select v-model="contract" class="form-control" style="margin-right:10px">
					<?php if (mainnet_contract_address != "") { ?><option value="<?php echo mainnet_contract_address; ?>">Mainnet</option><?php } ?>
					<?php if (testnet_contract_address != "") { ?><option value="<?php echo testnet_contract_address; ?>">Testnet</option><?php } ?>
				</select>
				<input type="text" placeholder="Search..." class="form-control" v-model="searcher">
				<i class="fa fa-search" style="margin:0 6px; cursor:pointer" @click="currentPage=1;search()"></i>
			</form>
			<button class="btn btn-primary" @click="showLogs = !showLogs" style="margin:14px 8px 0 0; float:right">View server logs</button>
		</div>
		<div class="bmt-page">
			<div class="row">
				<div class="col-xs-12">
					<div class="pad20">
						<?php if (mainnet_contract_address != "" || testnet_contract_address != "") { ?>
							<div class="portlet">
								<div class="portlet-body" style="display: block; overflow-x:scroll">
									<div v-show="showLogs" v-html="logs"></div>
									<table class="table table-striped table-bordered table-hover dataTableInit">
										<thead>
											<tr>
												<th>Title</th>
												<th>Owner</th>
												<th>Contract</th>
												<th>Network</th>
												<th>TokenId</th>
												<th class="text-center">Image</th>
												<th style="text-align:center"><i class="fa fa-edit"></i></th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="nft in nfts" v-show="nfts.length > 0 && !searching">
												<td v-html="nft.title"></td>
												<td v-html="nft.owner"></td>
												<td v-html="nft.contract"></td>
												<td v-if="nft.contract === '<?php echo mainnet_contract_address; ?>'">MAINNET</td>
												<td v-if="nft.contract === '<?php echo testnet_contract_address; ?>'">TESTNET</td>
												<td v-html="nft.tokenId"></td>
												<td class="text-center"><img style="float:none;display:inline-block" :src="JSON.parse(nft.metadata).image.replace('ipfs.io','hub.textile.io')" height="25"></td>
												<td style="text-align:center; width:60px">
													<a :href="'/bmt/nft/'+nft.contract+'/'+nft.ipfs_hash" id="seeBtn" class="bmt-small-button"><i class="fa fa-eye"></i></a>
												</td>
											</tr>
											<tr v-show="nfts.length === 0 && !searching">
												<td colspan="9">
													<h4 style="text-align: center; margin:20px 0">No NFTs found</h4>
												</td>
											</tr>
										</tbody>
									</table>
									<!--portlet-body-->
								</div>
								<nav aria-label="Page navigation example" v-if="!searching">
									<ul class="pagination" style="cursor: pointer; float:left;">
										<li class="page-item"><a class="page-link" @click="(currentPage == 1) ? '' : currentPage--"><i class="fa fa-angle-left"></i></a></li>
										<li :class="{'page-item': true, 'active': (currentPage == 1)}"><a class="page-link" v-html="(currentPage == 1) ? currentPage : currentPage-1" @click="currentPage = (currentPage == 1) ? currentPage : currentPage-1"></a></li>
										<li :class="{'page-item': true, 'active': (currentPage != 1)}"><a class="page-link" v-html="(currentPage == 1) ? currentPage+1 : currentPage" @click="currentPage = (currentPage == 1) ? currentPage+1 : currentPage"></a></li>
										<li class="page-item"><a class="page-link" v-html="(currentPage == 1) ? currentPage+2 : currentPage+1" @click="currentPage = (currentPage == 1) ? currentPage+2 : currentPage+1"></a></li>
										<li class="page-item"><a class="page-link" @click="(currentPage < totalPages) ? currentPage++ : ''"><i class="fa fa-angle-right"></i></a></li>
									</ul>
									<div style="float:left; margin: 20px;display:flex;">
										<input type="number" min="1" :max="totalPages" class="form-control" style="width:100px" v-model="customPage">
										<button @click="currentPage = parseInt(customPage)" style="margin:0 15px">Load page</button>
									</div>
								</nav>
								<nav aria-label="Page navigation example" v-if="searching">
									<ul class="pagination" style="cursor: pointer; float:left;">
										<li class="page-item"><a class="page-link" @click="(searchPage == 1) ? '' : searchPage--"><i class="fa fa-angle-left"></i></a></li>
										<li :class="{'page-item': true, 'active': (searchPage == 1)}"><a class="page-link" v-html="(searchPage == 1) ? searchPage : searchPage-1" @click="searchPage = (searchPage == 1) ? searchPage : searchPage-1"></a></li>
										<li :class="{'page-item': true, 'active': (searchPage != 1)}"><a class="page-link" v-html="(searchPage == 1) ? searchPage+1 : searchPage" @click="searchPage = (searchPage == 1) ? searchPage+1 : searchPage"></a></li>
										<li class="page-item"><a class="page-link" v-html="(searchPage == 1) ? searchPage+2 : searchPage+1" @click="searchPage = (searchPage == 1) ? searchPage+2 : searchPage+1"></a></li>
										<li class="page-item"><a class="page-link" @click="searchPage++"><i class="fa fa-angle-right"></i></a></li>
									</ul>
									<div style="float:left; margin: 20px;display:flex;">
										<input type="number" min="1" :max="totalPages" class="form-control" style="width:100px" v-model="customPage">
										<button @click="searchPage = parseInt(customPage)" style="margin:0 15px">Load page</button>
									</div>
								</nav>
							</div>
						<?php } else { ?>
							<div style="text-align:center; padding:40px">
								Please configure your NFT contracts first!
							</div>
						<?php } ?>
					</div>
					<!--content-->
				</div>
				<!--span10-->
			</div>
			<!--row-fluid-->
		</div>
	</div>
	<?php include('layout/footer.php'); ?>
	<script src="https://unpkg.com/vue@next"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		const Nfts = {
			data() {
				return {
					nfts: [],
					currentPage: (parseInt('<?php echo explode("/", $_SERVER['REQUEST_URI'])[3]; ?>') >= 1) ? parseInt('<?php echo explode("/", $_SERVER['REQUEST_URI'])[3]; ?>') : (localStorage.getItem('page') != null) ? parseInt(localStorage.getItem('page')) : 1,
					totalPages: 0,
					customPage: 1,
					searcher: '',
					searchPage: 1,
					searching: false,
					logs: {},
					showLogs: false,
					contract: '<?php if(mainnet_contract_address != ""){ echo mainnet_contract_address; }else{ echo testnet_contract_address; } ?>'
				}
			},
			watch: {
				currentPage: function(val) {
					this.currentPage = val
					localStorage.setItem('page', this.currentPage)
					this.search()
				},
				searchPage: function(val) {
					this.searchPage = val
					this.search()
					localStorage.setItem('searchPage', this.searchPage)
				},
				contract: function(val) {
					this.currentPage = 1
					this.search()
				}
			},
			methods: {
				async search() {
					this.searching = true
					let res = await axios.post('<?php echo umi_url; ?>/nfts/search', {
						owner: (this.searcher.indexOf('0x') !== -1) ? this.searcher : '',
						contract: this.contract,
						searcher: (this.searcher.indexOf('0x') === -1) ? this.searcher : '',
						page: this.currentPage
					})
					this.nfts = res.data.nfts.items
					this.currentPage = res.data.nfts.meta.currentPage
					this.totalPages = res.data.nfts.meta.totalPages
					this.searching = false
				},
				async getLogs() {
					try {
						let res = await axios.get('<?php echo umi_url; ?>/log')
						this.logs = res.data
					} catch (e) {
						this.logs = 'No logs available.'
					}
				}
			},
			async mounted() {
				this.search()
				this.getLogs()
				setInterval(() => this.getLogs(), 15000)
			}
		}

		Vue.createApp(Nfts).mount('#nfts')
	</script>
</body>

</html>