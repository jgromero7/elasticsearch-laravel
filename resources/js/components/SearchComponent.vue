<template>
    <div class="container">
        <div class="row justify-content-center">
            <div id="searcher" class="col-md-8 mb-5">
                <input v-model="query" type="text" name="q" class="form-control" placeholder="Search...">
            </div>
            
            <div class="col-md-8">
                <div class="card mb-4" v-for="article in articles" v-bind:key="article.id">
                    <div class="card-body">
                        <h5 class="card-title" v-html="heighlight(article.title, query)"></h5>
                        <p v-html="heighlight(article.tags, query)"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                query: '',
                articles: []
            }
        },
        watch: {
            query: function(val) {
                axios.get('/search/?q=' + this.query)
                    .then(response => {
                        this.article = []
                        this.articles = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        methods: {
            heighlight: function(text, query) {
                text = text.toLowerCase()
                query = query.toLowerCase().trim()
                return text.replace(query, '<span class="text-danger font-weight-bolder">' + query + '</span>')
            }
        },
        mounted() {
            console.log('Component Search mounted.')
        }
    }
</script>
<style scoped>
    #searcher {
        margin-top: 10px;
    }
</style>