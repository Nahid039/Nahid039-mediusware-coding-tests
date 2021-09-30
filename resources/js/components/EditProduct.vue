<template>
<form class="product" enctype="multipart/form-data">
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" v-model="form.product_name" placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Product SKU</label>
                                <input type="text" v-model="form.product_sku" placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea v-model="form.description" id="" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="updateProduct" type="submit" class="btn btn-lg btn-primary">Update</button>
            <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
            
        </section>
    </form>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import InputTag from 'vue-input-tag'

export default {
    data(){
    return {
      form:{
        product_name: '',
        product_sku: '',
        description: '',
      },
      errors:{}
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/product/'+id+'product')
  	.then(console.log(data))
  	.catch(console.log('error'))
  },

  productUpdate(){
  	  let id = this.$route.params.id
       axios.patch('/product/'+id,this.form)
       .then(() => {
           console.log("success");
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
}
</script>
