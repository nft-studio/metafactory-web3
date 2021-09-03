<?php
include('inc/initialize.php');
include('layout/header.php'); ?>
<?php include('layout/menu.php'); ?>

<style>
  .fa-spinner {
    animation: spinner 1.5s infinite ease-in-out
  }

  @keyframes spinner {
    from {
      transform: rotateZ(0);
    }

    to {
      transform: rotateZ(360deg);
    }
  }

  #closeImg {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    margin: 70px 20px;
    font-size: 22px;
    border: none;
    outline: none;
    background: black;
    border-radius: 999px;
    padding: 2px;
    color: #dadada
  }

  #closeImg:hover {
    color: white
  }
</style>
<script>
  //Navbar icon mobile toggle
  let ii = 0
  document.querySelector('.bmt-menu-toggle').addEventListener('click', () => {
    if (ii == 0) {
      document.querySelector('.bmt-menu-toggle').style.left = "263px";
      document.querySelector('.bmt-sidebar').style.left = "0";
      ii++;
    } else {
      document.querySelector('.bmt-menu-toggle').style.left = "12px";
      document.querySelector('.bmt-sidebar').style.left = "-250px";
      ii--
    }
  })
</script>

<div class="bmt-page-header">
  Minting interface
</div>

<div class="bmt-page" id="minting">
  <div class="row">
    <div class="col-xs-12">
      <div class="pad20">
        <div class="portlet" style="display: flex;">
          <form @submit.prevent="false" class="col-xs-12 col-md-6" style="margin:0 auto;">
            <div v-show="!preview">
              <div class="form-group">
                <h3>Minting settings</h3>
                <label for="set">Network</label>
                <select class="form-control" name="set" v-model="network">
                  <option value="testnet">Testnet</option>
                  <option value="mainnet">Mainnet</option>
                </select>
              </div>
              <div class="form-group">
                <label for="title">Receiver address</label>
                <input type="text" class="form-control" name="toAddress" placeholder="Insert receiver address (leave it blank to assign to owner address)" v-model="toAddress">
              </div>
              <div class="form-group">
                <label for="quantity">Amount</label>
                <input type="number" class="form-control" name="quantity" placeholder="Insert quantity" min="1" v-model="quantity">
              </div>
              <hr>
              <h3>Main info</h3>
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Insert title" v-model="titolo">
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" max="2000" style="height: 150px;" name="description" v-model="description" id="description"></textarea>
              </div>
              <div class="form-group" style="position:relative">
                <label for="image">Media File</label>
                <input type="file" class="form-control" name="image" id="image" @change="previewImage()">
                <img src="" class="col-xs-12" style="max-height: 300px; object-fit:contain" id="imgPreview" alt="" v-show="image.length >0">
                <button id="closeImg" @click="closeImage()" v-show="image.length >0"><i class="fa fa-times"></i></button>
              </div>
              <hr>
              <h3>Traits</h3>
              <?php $traits = returnDBObject("SELECT * FROM datatype_traits ORDER BY trait_order ASC", [], 1); ?>
              <?php foreach ($traits as $trait) { ?>
                <?php if ($trait['type'] == 'TEXT') { ?>
                  <div class="form-group">
                    <label for="title"><?php echo $trait['name']; ?></label>
                    <input type="text" class="form-control" name="<?php echo strtolower($trait['name']); ?>" placeholder="Insert <?php echo $trait['name']; ?>" v-model="<?php echo strtolower($trait['name']); ?>">
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
            <div v-show="preview">
              <pre>{{preview}}</pre>
            </div>
            <hr>
            <div class="form-group">
              <label for="title">Minting password</label>
              <input type="password" class="form-control" placeholder="Insert your minting password" name="pwdvector" v-model="pwdvector">
            </div>
            <button type="submit" v-if="!preview && !loading" class="btn btn-primary" style="width:100%" @click="mintNFT(false)">GENERATE NFT METADATA</button>
            <button type="submit" v-if="preview && !loading && !minted" class="btn btn-primary" style="width:100%" @click="mintNFT(true)">MINT NFT</button>
            <i class="fa fa-spinner ml-2" v-if="loading"></i>
            <h4 id="errorMinting" v-show="!editSuccess && !loading" style="color:#b12403"></h4>
            <h4 style="color:darkgreen" v-if="editSuccess">Nft created successfully <i class="fa fa-check ml-2" style="color:darkgreen"></i></h4>
            <button type="submit" v-if="minted" class="btn btn-primary" style="width:100%" @click="reload()">MINT NEW NFT</button>
          </form>
        </div>
        <!--portlet-->
      </div>

      <!--content-->
    </div>
    <!--span10-->
  </div>

  <script src="<?php echo $subdomain; ?>/bmt/layout/js/functions.js"></script>
  <!--row-fluid-->
</div>

<script src="https://unpkg.com/vue@next"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  const Minting = {
    data() {
      return {
        titolo: '',
        image: '',
        quantity: 1,
        loading: false,
        pwdvector: '',
        editSuccess: false,
        network: "testnet",
        proxy: {
          testnet: {
            address: "<?php echo testnet_proxy_address; ?>",
            mnemonic: "<?php echo testnet_proxy_mnemonic; ?>"
          },
          mainnet: {
            address: "<?php echo mainnet_proxy_address; ?>",
            mnemonic: "<?php echo mainnet_proxy_mnemonic; ?>"
          }
        },
        contract: {
          testnet: "<?php echo testnet_contract_address; ?>",
          mainnet: "<?php echo mainnet_contract_address; ?>"
        },
        toAddress: "",
        preview: "",
        description: "",
        <?php foreach ($traits as $trait) { echo strtolower($trait['name']).': "",'; } ?>
        minted: false
      }
    },
    methods: {
      reload() {
        const app = this
        app.pwdvector = ''
        app.titolo = ''
        app.toAddress = ''
        app.artist_name = ''
        app.preview = ''
        app.year = ''
        app.collection = ''
        app.description = ''
        app.preview = ''
        app.network = 'testnet'
        app.image = ''
        app.quantity = 1
        app.minted = false
      },
      async mintNFT(reallyMint = false) {
        if (this.titolo == '' || document.getElementById('image').value.length == 0 || document.getElementById('description').value.length == 0) {
          this.editSuccess = false
          document.getElementById('errorMinting').innerText = 'Compila tutti i campi correttamente'
        } else {
          if (!this.loading) {
            this.editSuccess = false
            this.loading = true
            const app = this
            //document.getElementById('description').value for description
            let data = new window.FormData();
            let attributes = []
            <?php foreach ($traits as $trait) { ?>
              attributes.push({
                trait_type: "<?php echo strtolower($trait['name']); ?>",
                value: app.<?php echo strtolower($trait['name']); ?>
              })
            <?php } ?>
            data.append("title", app.titolo.trim());
            data.append("file", document.getElementById('image').files[0]);
            data.append("description", app.description);
            data.append("proxy_address", this.proxy[this.network].address);
            data.append("contract", this.contract[this.network]);
            data.append('attributes', JSON.stringify(attributes));
            data.append('mint', reallyMint);
            if (this.toAddress.length > 0) {
              data.append('address', this.toAddress);
            }
            data.append('amount', parseInt(app.quantity));
            data.append('proxy_mnemonic', this.pwdvector + "*" + this.proxy[this.network].mnemonic);
            let mintingURL = '<?php echo umi_url; ?>/nfts/mint';
            if (parseInt(app.quantity) > 1 && app.preview !== "" && reallyMint === true) {
              mintingURL = '<?php echo umi_url; ?>/nfts/batch-mint';
            }
            let config = {
              method: 'post',
              url: mintingURL,
              headers: {
                'Content-Type': 'multipart/form-data'
              },
              data: data
            };

            let res = await axios(config)
            if (res.data.error == true) {
              document.getElementById('errorMinting').innerText = res.data.message
              app.loading = false
              app.editSuccess = false
            } else {
              if (app.preview !== "") {
                app.minted = true
              }
              app.preview = res.data
              app.loading = false
              app.editSuccess = true
            }
          }
        }
      },
      previewImage() {
        this.image = document.getElementById('image').value
        document.getElementById('imgPreview').src = URL.createObjectURL(document.getElementById('image').files[0])
      },
      closeImage() {
        document.getElementById('imgPreview').src = ''
        document.getElementById('image').value = ''
        this.image = ''
      }
    },
    mounted() {

    }
  }

  Vue.createApp(Minting).mount('#minting')
</script>