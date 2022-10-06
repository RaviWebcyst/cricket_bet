<template lang="">
<div>
    <div>
        <navbar />
        <Spinner name="moon" color="#c6172c" style="text-align:center;position:relative;top:200px;" v-if="loading==true" />
        <div class="container  col-md-6 mt-5">
                <table class="table mt-1">
                    <thead>
                        <tr>
                            <td>Match ID</td>
                            <td>Match Name</td>
                            <td>Team A Name</td>
                            <td>Team B Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <!-- <tbody v-if="matchs.length > 0">
                        <tr v-for="(match,i) in matchs">
                            <td>{{match.id}}</td>
                            <td>{{match.name}}</td>
                            <td>{{match.team_a_name}}</td>
                            <td>{{match.team_b_name}}</td>
                            <td><a href="javascript:;" class="btn btn-sm btn-success" @click="home(match.id)">Play</a></td>
                        </tr>
                    </tbody> -->
                    <tbody v-if="markets.length > 0">
                        <tr v-for="(market,i) in markets">
                            <td>{{market[0].marketId}}</td>
                            <td>{{market[0].marketName}}</td>
                            <td>{{market[0].runners[0].runnerName}}</td>
                            <td>{{market[0].runners[1].runnerName}}</td>
                            <td><a href="javascript:;" class="btn btn-sm btn-success" @click="home(market[0].marketId,market[0].runners[0].runnerName,market[0].runners[1].runnerName)">Play</a></td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>

</div>
</template>

<script>
import navbar from "./nav.vue";
import GooglePayButton from 'vue-google-pay'
export default {
    components: {
        navbar,
        "GooglePayButton": GooglePayButton
    },
    data() {
        return {
            matchs: [],
            markets:[],
            loading: true,
            options: {
                environment: 'PRODUCTION',
                buttonColor: 'white',
                allowedCardNetworks: [
                    'AMEX',
                    'DISCOVER',
                    'INTERAC',
                    'JCB',
                    'MASTERCARD',
                    'VISA'
                ],
                allowedCardAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                merchantInfo: {
                    merchantName: 'webdeveloper',
                    merchantId: 'BCR2DN4TZT6OTZQG'
                },
                transactionInfo: {
                    totalPriceStatus: 'FINAL',
                    totalPrice: '1.00',
                    currencyCode: 'INR',
                    countryCode: 'IN'
                },
                // tokenizationSpecification: {
                //     type: 'PAYMENT_GATEWAY',
                //     parameters: {
                //         gateway: 'example',
                //         gatewayMerchantId: 'exampleGatewayMerchantId'
                //     }
                // }
            }
        }
    },
    created() {
        axios.get("api/matchs").then(res => {
            this.loading = false;
            // from database
            this.matchs = res.data.matchs;
            // from api
            var result = res.data.result;
            this.markets= result;
            // console.log(result.length);
            // for(let i=0;i<result.length;i++){
            //     console.log(result[i][0]);
            // }

        }).catch(err => {
            this.loading = false;
            console.log(err);
        });

    },
    methods: {
        home(id,a,b) {
            localStorage.setItem("path", "Home");
            this.$router.push({ name: "Home", params: { id: id,a:a,b:b } });
        },
        processPayment() {

        },
        handleCancel() {

        },

        onBuyClicked() {
            if (!window.PaymentRequest) {
                console.log('Web payments are not supported in this browser.');
                return;
            }

            // Create supported payment method.
            const supportedInstruments = [
                {
                    supportedMethods: ['https://tez.google.com/pay'],
                    data: {
                        pa: 'merchant-vpa@xxx',
                        pn: 'Merchant Name',
                        tr: '1234ABCD',  // Your custom transaction reference ID
                        url: 'https://url/of/the/order/in/your/website',
                        mc: '1234', //Your merchant category code
                        tn: 'Purchase in Merchant',
                    },
                }
            ];

            // Create order detail data.
            const details = {
                total: {
                    label: 'Total',
                    amount: {
                        currency: 'INR',
                        value: '10.01', // sample amount
                    },
                },
                displayItems: [{
                    label: 'Original Amount',
                    amount: {
                        currency: 'INR',
                        value: '10.01',
                    },
                }],
            };

            // Create payment request object.
            let request = null;
            try {
                request = new PaymentRequest(supportedInstruments, details);
            } catch (e) {
                console.log('Payment Request Error: ' + e.message);
                return;
            }
            if (!request) {
                console.log('Web payments are not supported in this browser.');
                return;
            }

            //   var canMakePaymentPromise = checkCanMakePayment(request);
            canMakePaymentPromise
                .then((result) => {
                    showPaymentUI(request, result);
                })
                .catch((err) => {
                    console.log('Error calling checkCanMakePayment: ' + err);
                });
        },

 checkCanMakePayment(request) {
  // Check canMakePayment cache, use cache result directly if it exists.
  if (sessionStorage.hasOwnProperty(canMakePaymentCache)) {
    return Promise.resolve(JSON.parse(sessionStorage[canMakePaymentCache]));
  }

  // If canMakePayment() isn't available, default to assume the method is
  // supported.
  var canMakePaymentPromise = Promise.resolve(true);

  // Feature detect canMakePayment().
  if (request.canMakePayment) {
    canMakePaymentPromise = request.canMakePayment();
  }

  return canMakePaymentPromise
      .then((result) => {
        // Store the result in cache for future usage.
        sessionStorage[canMakePaymentCache] = result;
        return result;
      })
      .catch((err) => {
        console.log('Error calling canMakePayment: ' + err);
      });
},

    }
}
</script>

<style lang="">

</style>
