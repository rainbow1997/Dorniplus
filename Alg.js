const automorphSolver = (input) => {

    let automorphic = [];
    let countOfAutomorphic = 0;
    let automorphicing = (k) => {
        let tempOfK = k;
        let square = k * k;
        if (k == 0)
            return tempOfK;
        while (k > 0) {
            if ((k % 10) != (square % 10))
                return -1;
            k = Math.floor(k / 10);
            square = Math.floor(square / 10);
        }
        return tempOfK;

    };
    let i = 0;
    while (countOfAutomorphic < input) {

        let c = automorphicing(i);

        if (c > -1) {
            automorphic[countOfAutomorphic] = c;
            countOfAutomorphic++;
        }

        i++;


    }
    console.log(automorphic);
    console.log(countOfAutomorphic);
};


const digiRmaz = (rawInput) => {
    let input = {
        manner: {
            count: 4,
            ci: [8, 12, 17, 100],
            pi: [1, 3, 4, 10]
        },
        requestedProfit: 10,
    }
    console.log(input);
    const result = bubbleSort(input.manner.pi,input.manner.ci);
    console.log(result);
    input.manner.pi = result.arr;
    input.manner.ci = result.secondArr;
    console.log(input.manner);
    //p[i]=[10,4]
    let R =0;
    let day = 1;
    let i = input.manner.count - 1;
    while(R < input.requestedProfit)
    {
        if( i < 0 )
        {
            console.log('hhh');
            i=input.manner.count-1;
            day++;
        }
        console.log('i : ' +i + ' day is ' + day);
        let rTemp = day * input.manner.pi[i] - input.manner.ci[i];
        console.log('rTemp : ' + rTemp);
        console.log('R : ' + R );
        if(rTemp >= input.requestedProfit)
            break;

        R += rTemp;
        i--;

    }
    return day;

};
console.log(digiRmaz(1));
//automorphSolver(7);
function bubbleSort(arr,secondArr){

    result = {
        arr : [],
        newArr : []
    };

    for(let i = 0; i < arr.length; i++){

        for(let j = 0; j < arr.length - i - 1; j++){


            if(arr[j + 1] < arr[j]){

                [arr[j + 1],arr[j]] = [arr[j],arr[j + 1]];
                [secondArr[j + 1],secondArr[j]] = [secondArr[j],secondArr[j + 1]];
            }
        }
    };
    return {arr,secondArr};

};
