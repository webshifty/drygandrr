<template>
    <div>
        <header>
            <div class="header-content">
                <div class="d-flex align-items-center">
                    <a href="/" class="logo"><img src="/img/logo.svg" alt="" /></a>
                    <div class="header-content-divider" />
                    <DrugLogo width="52" height="18" fill="white"/>
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Про систему Друг</a></li>
                        <li><a href="#">Послуги</a></li>
                        <li><a href="#">Австралія</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="public">
            <div class="container-fluid px-0">
                <div class="row public-search justify-content-center mx-0">
                    <div class="col-12 col-sm-10 col-md-8 col-xl-6 flex-column justify-content-center">
                        <h1>
                            Як ми можемо вам допомогти?
                        </h1>
                        <div class="public-search-field d-flex align-items-center">
                            <input type="text" v-model="question" placeholder="Знайдіть відповіді на ваші запитання..." >
                            <SearchIcon class="public-search-field-icon ml-2 mr-4" width="21" height="21" fill="#949494" />
                        </div>
                    </div>
                </div>
                <div class="row mx-0 public-questions d-flex justify-content-center">
                    <div class="public-questions-header">
                        5 найчастіше заданих питань за вашою локацією
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="d-flex flex-column">
                            <QuestionItem question="Як потрапити на прийом" class="public-questions-item" />
                            <QuestionItem question="Як потрапити на прийом" class="public-questions-item" />
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import DrugLogo from "@/components/icons/DrugLogo"
import SearchIcon from "@/components/icons/Search"
import QuestionItem from "@/components/QuestionItem"

export default {
    name: "Public",
    data() {
        return {
            question: null
        }
    },
    components: {
        DrugLogo,
        SearchIcon,
        QuestionItem
    }
}
</script>

<style scoped>
/*Header*/

.header-content-divider {
    width: 1px;
    height: 47px;
    background: #F6F8FE;
    margin-left: 38px;
    margin-right: 23px;
}
/*Main*/

.public {
    background: white;
}
.public h1 {
    font-style: normal;
    font-weight: normal;
    font-size: 32px;
    line-height: 38px;
    color: #252525;
    text-align: center;
    margin-bottom: 32px;
}
/*Public search*/

.public-search {
    height: 373px;
    width: 100%;
    background: #F6F8FE;
    padding-top: 92px;
}
.public-search-field {
    height: 56px;
    color: #252525;
    background-color: #FFFFFF;
    border: 1px solid #949494;
    border-radius: 12px;
    font-size: 18px;
    line-height: 22px;
    overflow: hidden;
}
.public-search-field input {
    height: 100%;
    border: 0;
}
/*Public questions*/
.public-questions {
    /*padding-top: 55px;*/
}
.public-questions-header {
    margin-top: 55px;
    margin-bottom: 45px;
    max-width: 385px;
    font-size: 28px;
    line-height: 34px;
    text-align: center;
    color: #252525
}
.public-questions-item {
    margin-bottom: 16px;
}
</style>
