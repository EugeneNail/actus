import "./mood-chart.sass"
import React, {useEffect, useRef} from "react";
import Icon from "../icon/icon";
import {Mood, MoodIcons} from "../../model/mood";

type Props = {
    values: number[]
}

export default function MoodChart({values}: Props) {
    const canvasRef = useRef(null);
    const colors: {[key:number]: string} = {
        1: '#EF1630',
        2: '#F68C1E',
        3: '#4EA3D4',
        4: '#FFC540',
        5: '#8CCD2A',
    };


    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const valuesCount = 5
        const stepX = canvas.width / (values.length - 1);

        function normalize(value) {
            const result = canvas.height / valuesCount * (value - 1) + canvas.height / valuesCount / 2
            return -result
        }

        ctx.translate(10, canvas.height);

        const stepY = -canvas.height / valuesCount
        for (let i = 0; i <= valuesCount; i++) {
            ctx.beginPath()
            ctx.moveTo(0, stepY * i)
            ctx.lineTo(canvas.width, stepY * i)
            ctx.strokeStyle = '#666'
            ctx.lineWidth = 1
            ctx.stroke()
        }


        for (let i = 0; i < values.length - 1; i++) {
            const x0 = i * stepX;
            const y0 = normalize(values[i]);
            const x1 = (i + 1) * stepX;
            const y1 = normalize(values[i + 1]);

            const gradient = ctx.createLinearGradient(x0, y0, x1, y1);

            gradient.addColorStop(0, colors[values[i]]);
            gradient.addColorStop(0.35, colors[values[i]]);
            gradient.addColorStop(0.65, colors[values[i + 1]]);
            gradient.addColorStop(1, colors[values[i + 1]]);

            ctx.beginPath();
            ctx.moveTo(x0, y0);
            ctx.lineTo(x1, y1);
            ctx.strokeStyle = gradient;
            ctx.lineWidth = 3;
            ctx.stroke();

            ctx.beginPath()
            const radius = i % 10 == 0 ? 12 : 8
            ctx.arc(x0, y0, radius, 0, 2 * Math.PI)
            ctx.fillStyle = colors[values[i]]
            ctx.fill()
        }
    }, []);


    return (
        <div className="mood-chart">
            <p className="mood-chart__label">График Настроения</p>
            <div className="mood-chart__wrapper">
                <div className="mood-chart__moods">
                    <Icon className="mood-chart__mood radiating" name={MoodIcons[Mood.Radiating]}/>
                    <Icon className="mood-chart__mood happy" name={MoodIcons[Mood.Radiating]}/>
                    <Icon className="mood-chart__mood neutral" name={MoodIcons[Mood.Neutral]}/>
                    <Icon className="mood-chart__mood bad" name={MoodIcons[Mood.Bad]}/>
                    <Icon className="mood-chart__mood awful" name={MoodIcons[Mood.Awful]}/>
                </div>
                <canvas className="mood-chart__chart" ref={canvasRef} width={1000} height={500}/>
            </div>
        </div>
    );
}
