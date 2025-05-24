import "./transaction-chart.sass"
import React, {useEffect, useRef} from "react";
import Chart from "@/model/transaction/chart";
import ChartNode from "@/model/transaction/chart-node";

type Props = {
    scales: number[]
    main: Chart
    compared: Chart
}

export default function TransactionChart({scales, main, compared}: Props) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const paddingY = 40;
        const Xleft = 15;
        const Xright = 75;

        const stepsY = 3;
        let stepY = (canvas.height - paddingY * 2) / stepsY;

        for (let i = 0; i <= stepsY; i++) {
            ctx.setLineDash([20, 15])
            ctx.beginPath();
            ctx.moveTo(0, stepY * i + paddingY);
            ctx.lineTo(canvas.width - Xleft - Xright, stepY * i + paddingY);
            ctx.strokeStyle = '#ccc';
            ctx.lineWidth = 1;
            ctx.stroke();
            ctx.font = '30px Arial';
            ctx.fillStyle = '#777';
            ctx.fillText(scales[i], canvas.width - Xleft - Xright + 5, stepY * i + paddingY + 8)
            ctx.setLineDash([])
        }

        const stepX = (canvas.width - Xleft - Xright) / main.nodes.length
        stepY = (canvas.height - paddingY * 2 ) / 100

        for (let i = 0; i < compared.nodes.length -1; i++) {
            drawLine(canvas, ctx, compared.nodes, '#E2E2E2', paddingY, Xleft, i, i+1, stepX, stepY)
        }

        for (let i = 0; i < main.nodes.length -1; i++) {
            drawLine(canvas, ctx, main.nodes, '#D33F49', paddingY, Xleft, i, i+1, stepX, stepY)
        }

        const finalX = (main.nodes.length - 1) * stepX + Xleft
        const finalY = canvas.height - paddingY - stepY * main.nodes[main.nodes.length - 1].percent;


        // inner circle
        ctx.beginPath()
        ctx.moveTo(finalX, finalY)
        ctx.arc(finalX, finalY, 10, 0, 2 * Math.PI)
        ctx.stroke();

        // outer circle
        ctx.beginPath()
        ctx.arc(finalX, finalY, 5, 0, 2 * Math.PI)
        ctx.strokeStyle = 'white'
        ctx.stroke();
        ctx.fillStyle = 'white';
        ctx.fill()
    }, []);


    function drawLine(canvas, ctx, nodes: ChartNode[], color: string, paddingY: number, Xleft: number, i0: number, i1: number, stepX: number, stepY: number) {

        const x0 = i0 * stepX + Xleft;
        const y0 = (canvas.height - paddingY - stepY * nodes[i0].percent);
        const x1 = (i1) * stepX + Xleft;
        const y1 = (canvas.height - paddingY - stepY * nodes[i1].percent);

        const stepXOffset = stepX / 4;
        const x01 = x0 + stepXOffset;
        const y01 = y0 == y1 ? y1 : (y0 > y1 ? y0 - stepXOffset : y0 + stepXOffset);
        const x11 = x1 - stepXOffset;
        const y11 = y0 == y1 ? y1 : (y0 > y1 ? y1 + stepXOffset : y1 - stepXOffset);

        ctx.beginPath();
        ctx.moveTo(x0, y0);

        ctx.lineTo(x01, y01);
        ctx.lineTo(x11, y11);
        ctx.lineTo(x1, y1);

        ctx.strokeStyle = color;
        ctx.lineWidth = 5;
        ctx.stroke();

        ctx.lineTo(x1, canvas.height - paddingY);
        ctx.lineTo(x0, canvas.height - paddingY);
        ctx.lineTo(x0, y0);
        ctx.fillStyle = color + '11';
        ctx.fill();
    }


    return (
        <div className="transaction-chart">
            <p className="transaction-chart__label">Transaction Chart</p>
            <canvas className="transaction-chart__chart" ref={canvasRef} width={1000} height={500}/>
        </div>
    );
}
