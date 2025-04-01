import "./photo-uploader.sass"
import React, {ChangeEvent, useState} from "react";
import Icon from "../icon/icon";
import axios from "axios";

type Props = {
    name: string
    values: string[]
    deletePhoto: (name: string) => void
    onPhotosUploaded: (photos: string[]) => void
}

export default function PhotoUploader({name, values, deletePhoto, onPhotosUploaded}: Props) {
    const [isUploading, setUploading] = useState(false)
    const limit = 15

    async function loadBase64Images(event: ChangeEvent<HTMLInputElement>) {
        const files = event.target.files ?? [] as File[]
        const formData = new FormData();

        const remaining = limit - values.length;
        const allowed = Math.min(remaining, files.length)
        for (let i = 0; i < allowed; i++) {
            formData.append('photos[]', files[i])
        }

        setUploading(true)
        const {data, status} = await axios.post("/photos", formData)
        if (status == 201) {
            onPhotosUploaded(data)
            setUploading(false)
        }
    }


    return (
        <div className="photo-uploader">
            <p className="photo-uploader__label">Today's photos</p>
            <input disabled={isUploading} className="photo-uploader__input" name={name} id={name} type="file" multiple accept="image/*" onChange={loadBase64Images}/>
            <div className="photo-uploader__photos">
                {values && values.map((name) => (
                    <div className="photo-uploader__image-container" key={name}>
                        <div className="photo-uploader__delete-button" onClick={() => deletePhoto(name)}>
                            <Icon className="photo-uploader__delete-button-icon" bold name="close"/>
                        </div>
                        <img className="photo-uploader__img" src={`/photos/${name}`} alt={name}/>
                    </div>
                ))}
                {values?.length < limit && !isUploading &&
                    <label htmlFor={name} className="photo-uploader__button">
                        <Icon className="photo-uploader__icon" name="add_a_photo"/>
                        <p className="photo-uploader__message">Upload up to {limit} photos</p>
                    </label>
                }
            </div>

        </div>
    )
}
