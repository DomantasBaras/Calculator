<template>
  <div class="container rounded border border-gray-300 p-4">
    <!-- Calculator Result -->
    <div class="result rounded text-end lead fw-bold text-gray-800 bg-vue-dark">
      {{ calcVal || 0}}
    </div>

    <!-- Calculator Buttons -->
    <div class="row g-0">
      <div class="col-3 " v-for="btn in calcBtns" :key="btn">
        <div 
          class="lead text-gray-800 text-center m-1 py-3 bg-vue-dark rounded btn-hover"
          :class="{'bg-vue-green': ['C', '*', '/', '+', '-', '=', '%'].includes(btn)}"
          @click="action(btn)"
        >
          {{ btn }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Calculator',
  props: {
    msg: String,
  },

  data() {
    return {
      calcVal: '',
      calcBtns: ['C', '%', '=', '+', 7, 8, 9, '-', 4, 5, 6, '*', 1, 2, 3, '/', 0, '.'],
      operators: null,
      prevCalcVal: '',
    };
  },

  methods: {
    calculateResult(btn) {
      if (!isNaN(btn) || btn === '.') {
        this.calcVal += btn + '';
      }

      if (btn === 'C') {
        this.calcVal = '';
      }

      if (btn === '%') {
        this.calcVal = this.calcVal / 100 + '';
      }

      if (['/', '+', '-', '*'].includes(btn)) {
        this.operators = btn;
        this.prevCalcVal = this.calcVal;
        this.calcVal = '';
      }
    },

    async saveCalculation(result, expression) {
      try {
        const { data } = await this.$inertia.post('/save-calculation', { result, expression }) || {};

        if (data.success) {
          console.log('Calculation result saved successfully!');
        } else {
          console.error('Failed to save calculation result.', data.error);
        }
      } catch (error) {
        console.error('Error saving calculation result:', error);
      }
    },

    async handleEquals() {
  try {
    const expression = this.prevCalcVal + this.operators + this.calcVal;
    const result = new Function('return ' + expression)();
    this.prevCalcVal = '';
    this.operators = null;
    this.calcVal = result.toString();

    await this.saveCalculation(result, expression);
  } catch (error) {
    console.error('Error calculating result:', error);
  }
},


    action(btn) {
      if (btn === '=') {
        this.handleEquals();
      } else {
        this.calculateResult(btn);
      }
    },
  },
};
</script>

<style scoped>
.bg-vue-dark {
  background: #ffffff;
}

.btn-hover:hover {
  cursor: pointer;
  background: rgb(99, 99, 99);
}

.bg-vue-green {
  background: #3fb984;
}

.container {
  max-width: 600px;
  margin: 50px auto;
  background-color: rgb(255, 255, 255);
}

.row {
  display: flex;
  flex-wrap: wrap;
}

.result {
  max-width: 95%;
  margin: 2%;
  padding: 2%;
  padding-top: 5%;
  margin-top: 5%;
}

.col-3 {
  flex: 0 0 25%;
  max-width: 25%;
}

.text-white {
  color: #fff;
}
</style>
